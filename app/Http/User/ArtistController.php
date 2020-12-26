<?php

namespace App\Http\User;

use App\Core\Controller;
use App\Domain\User\Artist;
use App\Http\User\Resources\ArtistResource;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        return ArtistResource::collection(
            Artist::with('albums')
                ->orderBy('name')
                ->get()
        );
    }

    public function show(Artist $artist)
    {
        $artist->load('albums', 'albums.songs');

        return (new ArtistResource($artist));
    }
}
