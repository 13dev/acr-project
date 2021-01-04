<?php

namespace App\Http\Song\Actions;

use App\Core\Services\Streamer\LaravelStreamer;
use App\Core\Services\Streamer\SpacesStreamer;
use App\Core\Services\Streamer\StreamerResolver;
use App\Domain\Song\Song;

class StreamAction
{
    public function __invoke(Song $song)
    {
        // Try to choose the best streamer
        return StreamerResolver::resolve([
            SpacesStreamer::class,
            LaravelStreamer::class,
        ], $song);
    }
}
