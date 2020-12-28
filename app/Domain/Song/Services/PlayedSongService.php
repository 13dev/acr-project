<?php

namespace App\Domain\Song\Services;

use App\Domain\Song\PlayedSong;
use Illuminate\Support\Collection;

class PlayedSongService
{
    public function incrementPlays(string $songId): PlayedSong
    {
        /** @var PlayedSong $song */
        $playedSong = PlayedSong::firstOrCreate(['song_id' => $songId], [
            'song_id' => $songId,
            'times' => 0,
        ]);

        $playedSong->increment('times');

        return $playedSong;
    }

    public function getTopSongs($limit = 10): Collection
    {
        return PlayedSong::with('song')
            ->limit($limit)
            ->orderBy('times', 'desc')
            ->get()
            ->pluck('song');
    }

    public function getTopArtists($limit = 10): Collection
    {
        return PlayedSong::with('song.album.artist')
            ->limit($limit)
            ->orderBy('times', 'desc')
            ->get()
            ->pluck('song.album.artist');
    }

    public function getTopAlbums($limit = 10): Collection
    {
        return PlayedSong::with('song.album')
            ->limit($limit)
            ->orderBy('times', 'desc')
            ->get()
            ->pluck('song.album');
    }


}
