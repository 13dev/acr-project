<?php


namespace App\Http\User\Actions;


use App\Domain\User\Artist;
use App\Http\User\Resources\ArtistResource;

class ListArtistsAction
{
    public function __invoke()
    {
        return ArtistResource::collection(
            Artist::with('albums')
                ->orderBy('name')
                ->get()
        );
    }
}
