<?php

namespace App\Http\Song\Actions;

use App\Domain\Song\Services\PlayedSongService;
use App\Http\Album\Resources\AlbumResource;

class TopAlbumsAction
{
    public function __invoke(PlayedSongService $playedSongService)
    {
        return AlbumResource::collection(
            $playedSongService->getTopAlbums()
        );
    }
}
