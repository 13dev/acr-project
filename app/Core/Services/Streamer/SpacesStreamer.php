<?php


namespace App\Core\Services\Streamer;

use Carbon\Carbon;
use GuzzleHttp\Stream\Stream;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Response as ResponseAlias;

class SpacesStreamer extends Streamer
{
    public function stream(): Response
    {
        BinaryFileResponse::trustXSendfileTypeHeader();

        $disk = Storage::disk('spaces');
        $filePath = config('songs.spaces_path') . $this->song->path;
        $path = $disk->temporaryUrl($filePath, Carbon::now()->addMinutes(5));

        return ResponseAlias::streamed(
            $this->contentType,
            $disk->getSize($filePath),
            basename($filePath),
            function ($offset, $length) use ($path) {
                $stream = Stream::factory(fopen($path, 'rb'));
                $stream->seek($offset);
                while (!$stream->eof()) {
                    echo $stream->read($length);
                }
                $stream->close();
            });

    }
}
