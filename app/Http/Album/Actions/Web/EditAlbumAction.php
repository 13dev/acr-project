<?php

namespace App\Http\Album\Actions\Web;

use App\Domain\Album\Album;
use App\Domain\Artist\Artist;
use App\Http\Album\Requests\EditAlbumRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EditAlbumAction
{
    public function __invoke(Album $album, EditAlbumRequest $request)
    {
        $data = $request->validated();

        if($request->has('cover')) {
            $filename = $this->uploadCover(
                $request->file('cover')
            );

            if($filename) {
                $data = array_merge($data, ['cover' => $filename]);
            }

        }

        $album->update($data);

        return redirect()->route('dashboard');
    }

    private function uploadCover(?UploadedFile $file)
    {
        if($file === null) {
            return null;
        }

        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/covers'), $fileName);
        return $fileName;
    }

    public function view(Album $album)
    {
        $artists = Artist::all();

        return view('albums.edit', compact('album', 'artists'));
    }
}
