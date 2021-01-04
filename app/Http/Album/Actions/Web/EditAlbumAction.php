<?php

namespace App\Http\Album\Actions\Web;

use App\Domain\Album\Album;
use App\Http\Album\Requests\EditAlbumRequest;

class EditAlbumAction
{
    public function __invoke(Album $album, EditAlbumRequest $request)
    {
        $album->update($request->validated());

        return redirect()->route('dashboard');
    }

    public function view(Album $album)
    {
        return view('albums.create', compact('album'));
    }
}
