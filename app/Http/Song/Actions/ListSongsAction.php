<?php


namespace App\Http\Song\Actions;


use App\Domain\Song\Song;
use App\Http\Song\Resources\SongResource;

class ListSongsAction
{
    public function __invoke()
    {
        return SongResource::collection(Song::all());
    }
}
