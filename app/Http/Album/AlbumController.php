<?php

namespace App\Http\Album;

use App\Core\Controller;
use App\Http\Album\Resources\AlbumResource;
use App\Models\Album;

class AlbumController extends Controller
{
    public function index()
    {
        return AlbumResource::collection(
            Album::orderBy('name')
                ->with('artist')
                ->withCount('songs')
                ->get()
        );
    }

    public function show(Album $album)
    {
        $album->load('artist', 'songs')
            ->withCount('songs');

        return new AlbumResource($album);
    }
}
