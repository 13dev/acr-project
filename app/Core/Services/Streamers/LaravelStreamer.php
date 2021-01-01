<?php


namespace App\Core\Services\Streamers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class LaravelStreamer extends Streamer
{
    public function stream(): Response
    {
        BinaryFileResponse::trustXSendfileTypeHeader();

        return response()->download(
            config('songs.path') . $this->song->path
        );

    }
}
