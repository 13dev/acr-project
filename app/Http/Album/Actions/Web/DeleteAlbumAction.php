<?php


namespace App\Http\Album\Actions\Web;


use App\Domain\Album\Album;

class DeleteAlbumAction
{
    public function __invoke(Album $album)
    {
        $album->delete();

        return redirect()->route('dashboard');
    }
}
