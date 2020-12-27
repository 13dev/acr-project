<?php

namespace App\Http\Song\Actions;

use App\Core\Services\Streamers\LaravelStreamer;
use App\Domain\Song\Song;

class StreamAction
{
    public function __invoke(Song $song)
    {
        $streamer = new LaravelStreamer();
        $streamer->setSong($song);
        return $streamer->stream();
    }
}
