<?php


namespace App\Core\Services\Streamers;

use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class SpacesStreamer extends Streamer
{
    public function stream(): Response
    {
        BinaryFileResponse::trustXSendfileTypeHeader();

        return Storage::disk('spaces')
            ->download(config('songs.spaces_path') . $this->song->path);
    }
}
