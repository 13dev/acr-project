<?php


namespace App\Http\Artist\Actions;


use App\Domain\Artist\Artist;
use App\Http\Artist\Resources\ArtistResource;

class ListArtistsAction
{
    public function __invoke()
    {
        $artists = Artist::with('albums')
            ->orderBy('name')
            ->get();

        return ArtistResource::collection($artists);
    }
}
