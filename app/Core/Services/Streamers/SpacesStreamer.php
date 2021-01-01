<?php


namespace App\Core\Services\Streamers;

use Carbon\Carbon;
use GuzzleHttp\Stream\Stream;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Response as ResponseAlias;

class SpacesStreamer extends Streamer
{


    public function stream(): Response
    {
        $filePath = config('songs.spaces_path') . $this->song->path;
        $disk = Storage::disk('spaces');
        $path = $disk->temporaryUrl($filePath, Carbon::now()->addMinutes(5));

        $name = basename($filePath);
        $size = $disk->getSize($filePath);
        $type = 'audio/mp3';

        return ResponseAlias::streamed($type, $size, $name, function($offset, $length) use ($path) {
            $stream = Stream::factory(fopen($path, 'rb'));
            $stream->seek($offset);
            while (!$stream->eof()) {
                echo $stream->read($length);
            }
            $stream->close();
        });

//        BinaryFileResponse::trustXSendfileTypeHeader();
//
//
//
//        return Storage::disk('spaces')->download($filePath, null, [
//            'Accept-Ranges' =>'bytes'
//        ]);

    }
}
