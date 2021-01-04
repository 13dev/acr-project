<?php


namespace App\Http\Album\Actions\Web;


use App\Domain\Album\Album;
use App\Http\Album\Requests\CreateAlbumRequest;

class CreateAlbumAction
{
    public function __invoke(CreateAlbumRequest $request)
    {
        Album::create($request->validated());

        return redirect()->route('dashboard');
    }

    public function view()
    {
        return view('albums.create');
    }
}
