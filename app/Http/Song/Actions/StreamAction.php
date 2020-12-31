<?php

namespace App\Http\Song\Actions;

use App\Core\Services\Streamers\LaravelStreamer;
use App\Core\Services\Streamers\SpacesStreamer;
use App\Core\Services\Streamers\StreamerResolver;
use App\Domain\Song\Song;
use Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

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
