<?php


namespace App\Http\User\Actions;


use App\Domain\User\Artist;
use App\Http\User\Resources\ArtistResource;

class GetArtistAction
{
    public function __invoke(Artist $artist)
    {
        $artist->load('albums', 'albums.songs');

        return new ArtistResource($artist);
    }
}
