<?php


namespace App\Http\Song\Actions;


use App\Domain\Song\Services\PlayedSongService;
use App\Http\Song\Resources\SongResource;

class TopSongsAction
{
    public function __invoke(PlayedSongService  $playedSongService)
    {
        return SongResource::collection(
            $playedSongService->getTopSongs()
        );
    }
}
