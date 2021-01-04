<?php

namespace App\Http\Album\Actions\Web;

use App\Domain\Album\Album;
use App\Domain\Album\Services\UploadCoverService;
use App\Domain\Artist\Artist;
use App\Http\Album\Requests\CreateAlbumRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CreateAlbumAction
{
    public function __invoke(CreateAlbumRequest $request, UploadCoverService $uploadCoverService)
    {
        $filename = $uploadCoverService(
            $request->file('cover')
        );

        Album::create(array_merge($request->validated(), ['cover' => $filename]));

        return redirect()->route('dashboard');
    }

    public function view()
    {
        return view('albums.create', [
            'artists' => Artist::all(),
        ]);
    }
}
