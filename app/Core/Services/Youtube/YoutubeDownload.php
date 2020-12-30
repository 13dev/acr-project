<?php


namespace App\Core\Services\Youtube;

use DateInterval;
use Illuminate\Support\Str;
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
        $this->youtubeMetadata = new YoutubeMetadata();

        $id = Youtube::parseVidFromURL($url);

        $info = Youtube::getVideoInfo($id);
        $this->youtubeMetadata
            ->setId($id)
            ->setTitle($info->snippet->title)
            ->setDuration($this->ISO8601ToSeconds($info->contentDetails->duration));
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

        $output = function ($type, $line) use ($outputCallback) {

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

        Terminal::output($output)
            ->with([
                'id' => $this->getInfo()->getId(),
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
     * Convert ISO 8601 values like P2DT15M33S
     * to a total value of seconds.
     *
     * @param string $ISO8601
     * @throws \Exception
     */
    private function ISO8601ToSeconds($ISO8601)
    {
        $interval = new DateInterval($ISO8601);

        return ($interval->d * 24 * 60 * 60) +
            ($interval->h * 60 * 60) +
            ($interval->i * 60) +
            $interval->s;
    }

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
     * @return YoutubeMetadata
     */
    public function getInfo(): YoutubeMetadata
    {
        return $this->youtubeMetadata;
    }

}
