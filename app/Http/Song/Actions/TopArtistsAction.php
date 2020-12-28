<?php


namespace App\Http\Song\Actions;


use App\Domain\Song\Services\PlayedSongService;
use App\Http\Artist\Resources\ArtistResource;

class TopArtistsAction
{
    public function __invoke(PlayedSongService $playedSongService)
    {
        return ArtistResource::collection(
            $playedSongService->getTopArtists()
        );
    }
}
