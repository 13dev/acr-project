<?php


namespace App\Core\Services\Streamers;

use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class SpacesStreamer extends Streamer
{


    public function stream(): Response
    {
        BinaryFileResponse::trustXSendfileTypeHeader();

        $filePath = config('songs.spaces_path') . $this->song->path;

        return Storage::disk('spaces')->download($filePath, null, [
            'Accept-Ranges' =>'bytes'
        ]);

    }
}
