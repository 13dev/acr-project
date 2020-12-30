<?php


namespace App\Core\Services\Youtube;

use DateInterval;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use TitasGailius\Terminal\Terminal;
use Youtube;

class YoutubeDownload
{
    private YoutubeObject $youtubeObject;
    private YoutubeMetadata $youtubeMetadata;

    /**
     * @param $url
     * @return $this
     * @throws \Exception
     */
    public function from($url): self
    {
        $this->youtubeObject = new YoutubeObject();
        $this->youtubeMetadata = $this->buildMetadata($url);

        return $this;
    }

    /**
     * Only mp3
     * @param string $path
     * @param string|null $name
     * @param callable|null $outputCallback
     * @return YoutubeObject
     * @throws \JsonException
     */
    public function download(string $path = '', ?string $name = null, callable $outputCallback = null): YoutubeObject
    {
        if (!empty($path)) {
            $path .= '/';
        }

        if (!$name) {
            $name = (string)Str::uuid();
        }

        $youtubeObject = $this->getYoutubeObject()
            ->setPath($path)
            ->setFilename($name);

        Terminal::output($this->parseOutputDownload($outputCallback))
            ->with([
                'id' => $this->youtubeMetadata->getId(),
                'options' => $this->buildDownloaderOptions($path, $name),
            ])
            ->run('node downloader.js \
                --options="{{ $options }}" \
                --id="{{ $id }}" \
            ');

        // youtube-dl --audio-quality 0 --audio-format mp3 --continue --ignore-errors --extract-audio --output "{{ $outputPath }}{{ $outputName }}.%(ext)s" {{ $url }}

        return $youtubeObject
            ->setPath($path)
            ->setFilename($name);
    }

    /**
     * Parse the lines on download function
     * @param $outputCallback
     * @return \Closure
     */
    private function parseOutputDownload($outputCallback)
    {
        return function ($type, $line) use ($outputCallback) {

            if ($type === Process::ERR) {
                return;
            }

            if (($parsedLine = json_decode($line)) === null) {
                return;
            }

            if (isset($parsedLine->progress) && json_last_error() === JSON_ERROR_NONE) {

                if ($outputCallback === null) {
                    print sprintf("Downloading [%s] - ", $parsedLine->videoId);
                    print number_format($parsedLine->progress->percentage, 2) . "%" . PHP_EOL;
                    return;
                }

                if (is_callable($outputCallback)) {
                    $outputCallback($parsedLine);
                }
            }

            // Done!
            if (isset($parsedLine->stats)) {
                // Str::replaceFirst('hqdefault', 'maxresdefault', $parsedLine->thumbnail);
                $this->downloadThumbnail($parsedLine->thumbnail);
            }
        };
    }

    /**
     * @param $path
     * @param $name
     * @return string
     * @throws \JsonException
     */
    private function buildDownloaderOptions($path, $name): string
    {
        $data = [
            'ffmpegPath' => '/usr/bin/ffmpeg',
            'youtubeVideoQuality' => 'highestaudio',
            'queueParallelism' => 1,
            'progressTimeout' => 0,
            'allowWebm' => false,
            'outputPath' => $path,
            'outputName' => $name,
        ];

        $javaScriptOptions = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
        return addslashes($javaScriptOptions);
    }

    /**
     * @param string $path
     * @param string $name
     * @return $this
     */
    public function thumbnail(string $path, string $name)
    {
        $this->getYoutubeObject()
            ->setThumbPath($path)
            ->setThumbName($name);

        return $this;
    }

    /**
     * Download thumnail
     * @param string $url
     * @return string
     */
    private function downloadThumbnail(string $url): string
    {
        $youtubeObject = $this->getYoutubeObject();

        $content = file_get_contents($url);
        file_put_contents($youtubeObject->getThumbnailLocation(), $content);

        return $youtubeObject->getThumbnailLocation();
    }

    /**
     * @return YoutubeObject
     */
    public function getYoutubeObject(): YoutubeObject
    {
        return $this->youtubeObject;
    }

    /**
     * Build metadata Object
     * @param string $url
     * @throws \JsonException
     */
    private function buildMetadata(string $url)
    {
        $info = $this->getVideoInformation($url);

        return (new YoutubeMetadata())
            ->setTitle($info->title ?? '')
            ->setDuration($info->duration ?? '')
            ->setId($info->id ?? '');
    }

    /**
     * Runs a process and retrive video Info
     * @param string $url
     * @return object
     * @throws \JsonException
     */
    private function getVideoInformation(string $url): object
    {
        $response = Terminal::run('youtube-dl --dump-json --skip-download ' . $url);
        $response->throw();

        return json_decode($response->output(), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return YoutubeMetadata
     */
    public function getYoutubeMetadata(): YoutubeMetadata
    {
        return $this->youtubeMetadata;
    }

}
