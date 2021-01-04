<?php

namespace App\Core\Services\Streamer;

use App\Domain\Song\Song;

abstract class Streamer implements Streamable
{
    protected Song $song;
    protected string $contentType;

    public function setSong($song)
    {
        $this->song = $song;
        $this->contentType = 'audio/' . pathinfo($this->song->path, PATHINFO_EXTENSION);
    }
}
