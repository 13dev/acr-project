<?php


namespace App\Http\Album\Actions;


use App\Domain\Album\Album;
use App\Http\Album\Resources\AlbumResource;

class GetAlbumAction
{
    public function __invoke(Album $album)
    {
        $album->load('artist', 'songs')
            ->withCount('songs');

        return new AlbumResource($album);
    }
}
