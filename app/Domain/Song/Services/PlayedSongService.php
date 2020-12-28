<?php

namespace App\Domain\Song\Services;

use App\Domain\Song\PlayedSong;

class PlayedSongService
{
    public function incrementPlays(string $songId): PlayedSong
    {
        /** @var PlayedSong $song */
        $playedSong = PlayedSong::firstOrCreate(['song_id' => $songId], [
            'song_id' => $songId,
            'times' => -1,
        ]);

        $playedSong->increment('times');

        return $playedSong;
    }
}
