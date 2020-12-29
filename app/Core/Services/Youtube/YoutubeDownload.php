<?php


namespace App\Core\Services\Youtube;

use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use TitasGailius\Terminal\Terminal;

class YoutubeDownload
{
    private YoutubeObject $youtubeObject;

    public function from($url): self
    {
        $this->youtubeObject = new YoutubeObject();
        $this->youtubeObject->setUrl($url);
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
                'url' => $youtubeObject->getUrl(),
                'options' => $this->buildDownloaderOptions($path, $name),
            ])
            ->run('node downloader.js \
                --options="{{ $options }}" \
                --url="{{ $url }}"
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
     * Get Info by Params
     * @return YoutubeMetadata
     * @throws \JsonException
     */
    public function getInfo(): YoutubeMetadata
    {
        $youtubeMetadata = new YoutubeMetadata();

        $process = Process::fromShellCommandline('youtube-dl \
            --print-json \
            "$url"
        ');

        $process
            ->setTimeout(null)
            ->setEnv([
                'url' => $this->getYoutubeObject()->getUrl(),
            ])
            ->mustRun()
            ->wait();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $outputProcess = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);
        $youtubeMetadata
            ->setTitle($outputProcess['title'])
            ->setDuration($outputProcess['duration']);

        unset($outputProcess['title'], $outputProcess['duration']);

        $youtubeMetadata->setMetadata($outputProcess);

        //return array_intersect_key($outputProcess, array_flip($params));

        return $youtubeMetadata;

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

}
