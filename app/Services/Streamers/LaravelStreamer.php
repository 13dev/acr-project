<?php


namespace App\Services\Streamers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LaravelStreamer extends Streamer
{

    public function stream(): ?BinaryFileResponse
    {
        if (config('music.use_cloud')) {
            return null;
        }

        dump( storage_path('app/' . $this->song->path));

        $response = new BinaryFileResponse(
            storage_path('app/' . $this->song->path)
        );

        BinaryFileResponse::trustXSendfileTypeHeader();

        return $response;

    }
}
