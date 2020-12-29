<?php


namespace App\Core\Services\Youtube;


class YoutubeMetadata
{
    private string $title;
    private int $duration;
    private array $metadata;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return YoutubeMetadata
     */
    public function setTitle(string $title): YoutubeMetadata
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        // ffprobe -i <file> -show_entries format=duration -v quiet -of csv="p=0"
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return YoutubeMetadata
     */
    public function setDuration(int $duration): YoutubeMetadata
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     * @return YoutubeMetadata
     */
    public function setMetadata(array $metadata): YoutubeMetadata
    {
        $this->metadata = $metadata;
        return $this;
    }

}
