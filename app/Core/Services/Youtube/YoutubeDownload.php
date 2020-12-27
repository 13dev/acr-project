<?php


namespace App\Core\Services\Youtube;

use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class YoutubeDownload
{
    private string $url;
    private string $outputPath;
    private ?string $outputPathThumb;
    private ?string $outputNameThumb;
    private bool $withThumbnail = false;

    public function from($url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Only mp3
     * @param string $outputPath
     * @param string|null $outputName
     * @return string
     */
    public function download(string $outputPath = '', ?string $outputName = null): string
    {
        if (!empty($outputPath)) {
            $outputPath .= '/';
        }

        if (!$outputName) {
            $outputName = (string)Str::uuid();
        }

        $process = Process::fromShellCommandline('youtube-dl \
            --audio-quality 0 \
            --audio-format mp3 \
            --continue \
            --no-overwrites \
            --ignore-errors \
            --extract-audio \
            --output "$outputPath$outputName.%(ext)s" \
            "$url"
        ');

        print_r($process->getCommandLine());

        $process->run(null, [
            'url' => $this->getUrl(),
            'outputPath' => $outputPath,
            'outputName' => $outputName,
        ]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if ($this->withThumbnail) {
            $this->downloadThumnail();
        }

        return $outputPath . $outputName;
    }

    public function withThumbnail(string $outputPath = null, string $outputName = null): self
    {
        if (!empty($outputPath)) {
            $outputPath .= '/';
        }

        if (!$outputName) {
            $outputName = (string)Str::uuid();
        }

        $this->outputNameThumb = $outputName;
        $this->outputPathThumb = $outputPath;
        $this->withThumbnail = true;

        return $this;
    }

    /**
     * Get Info by Params
     * @param mixed ...$params
     * @return mixed
     * @throws \JsonException
     */
    public function getInfo(...$params)
    {
        $process = Process::fromShellCommandline('youtube-dl \
            --print-json \
            "$url"
        ');

        $process->run(null, [
            'url' => $this->getUrl(),
        ]);

        if(!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $outputProcess = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);

        return array_intersect_key($outputProcess, array_flip($params));

    }

    private function downloadThumnail(): void
    {
        $process = Process::fromShellCommandline('youtube-dl \
            --write-thumbnail \
            --skip-download \
            --output "$outputPath$outputName.%(ext)s" \
            "$url"
        ');

        $process->run(null, [
            'url' => $this->getUrl(),
            'outputName' => $this->outputNameThumb,
            'outputPath' => $this->outputPathThumb,
        ]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

}
