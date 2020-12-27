<?php


namespace App\Core\Services\Youtube;

use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class YoutubeDownload
{
    private YoutubeObject $youtubeObject;
    private bool $withThumbnail = false;

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
     * @return YoutubeObject
     */
    public function download(string $path = '', ?string $name = null): YoutubeObject
    {
        $youtubeObject = $this->getYoutubeObject();

        if (!empty($path)) {
            $path .= '/';
        }

        if (!$name) {
            $name = (string) Str::uuid();
        }

        $youtubeObject->setPath($path)
            ->setFilename($name);

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

        $process->run(null, [
            'url' => $youtubeObject->getUrl(),
            'outputPath' => $youtubeObject->getPath(),
            'outputName' => $youtubeObject->getFilename(),
        ]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if ($this->withThumbnail) {
            $this->downloadThumnail();
        }

        return $youtubeObject;
    }

    public function withThumbnail(string $path = null, string $name = null): self
    {
        if (!empty($path)) {
            $path .= '/';
        }

        if (!$name) {
            $name = (string) Str::uuid();
        }

        $this->getYoutubeObject()
            ->setThumbName($name)
            ->setThumbPath($path);

        $this->withThumbnail = true;

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

        $process->run(null, [
            'url' => $this->getYoutubeObject()->getUrl(),
        ]);

        if(!$process->isSuccessful()) {
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

    private function downloadThumnail(): void
    {
        $process = Process::fromShellCommandline('youtube-dl \
            --write-thumbnail \
            --skip-download \
            --output "$outputPath$outputName.%(ext)s" \
            "$url"
        ');

        $youtubeObject = $this->getYoutubeObject();

        $process->run(null, [
            'url' => $youtubeObject->getUrl(),
            'outputName' => $youtubeObject->getThumbName(),
            'outputPath' => $youtubeObject->getThumbPath(),
        ]);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * @return YoutubeObject
     */
    public function getYoutubeObject(): YoutubeObject
    {
        return $this->youtubeObject;
    }

}
