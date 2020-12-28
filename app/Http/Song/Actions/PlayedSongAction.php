<?php


namespace App\Http\Song\Actions;


use App\Domain\Song\Services\PlayedSongService;
use App\Domain\Song\Song;
use App\Http\Song\Resources\PlayedSongResource;

class PlayedSongAction
{
    /**
     * @var PlayedSongService
     */
    private PlayedSongService $playedSongService;

    public function __construct(PlayedSongService $playedSongService)
    {
        $this->playedSongService = $playedSongService;
    }

    public function __invoke(Song $song)
    {
        $playedSong = $this->playedSongService->incrementPlays(
            $song->getKey()
        );

        return new PlayedSongResource($playedSong);
    }
}
