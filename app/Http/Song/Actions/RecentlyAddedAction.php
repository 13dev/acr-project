<?php


namespace App\Http\Song\Actions;

use App\Domain\Song\Song;
use App\Http\Song\Resources\SongResource;

class RecentlyAddedAction
{
    public function __invoke()
    {
        $songs = Song::orderBy('album_id', 'desc')
            ->orderBy('track')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->with('album')
            ->get();

        return SongResource::collection($songs);
    }
}
