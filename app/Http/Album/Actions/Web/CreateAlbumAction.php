<?php

namespace App\Http\Album\Actions\Web;

use App\Domain\Album\Album;
use App\Domain\Artist\Artist;
use App\Http\Album\Requests\CreateAlbumRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CreateAlbumAction
{
    public function __invoke(CreateAlbumRequest $request)
    {
        $filename = $this->uploadCover(
            $request->file('cover')
        );

        Album::create(array_merge($request->validated(), ['cover' => $filename]));

        return redirect()->route('dashboard');
    }

    private function uploadCover(UploadedFile $file)
    {
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/covers'), $fileName);
        return $fileName;
    }

    public function view()
    {
        return view('albums.create', [
            'artists' => Artist::all(),
        ]);
    }
}
