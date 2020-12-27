<?php


namespace App\Http\Album\Actions;


use App\Domain\Album\Album;
use App\Http\Album\Resources\AlbumResource;

class ListAlbumsAction
{
    public function __invoke()
    {
        return AlbumResource::collection(
            Album::orderBy('name')
                ->with('artist')
                ->withCount('songs')
                ->get()
        );
    }
}
