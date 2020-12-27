<?php


namespace App\Http\Artist\Actions;


use App\Domain\Artist\Artist;
use App\Http\Artist\Resources\ArtistResource;

class GetArtistAction
{
    public function __invoke(Artist $artist)
    {
        $artist->load('albums', 'albums.songs');

        return new ArtistResource($artist);
    }
}
