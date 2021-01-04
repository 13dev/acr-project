<?php

namespace App\Http\Album\Actions\Web;

use App\Domain\Album\Album;
use App\Domain\Album\Services\UploadCoverService;
use App\Domain\Artist\Artist;
use App\Http\Album\Requests\EditAlbumRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EditAlbumAction
{
    public function __invoke(Album $album, EditAlbumRequest $request, UploadCoverService $uploadCoverService)
    {
        $data = $request->validated();

        if ($request->has('cover')) {
            $filename = $uploadCoverService(
                $request->file('cover')
            );

            $data = array_merge($data, ['cover' => $filename]);
        }

        $album->update($data);

        return redirect()->route('dashboard');
    }


    public function view(Album $album)
    {
        $artists = Artist::all();

        return view('albums.edit', compact('album', 'artists'));
    }
}
