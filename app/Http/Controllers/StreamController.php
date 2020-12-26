<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Services\Streamers\LaravelStreamer;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    public function show(Request $request, Song $song)
    {
//        $stream = Storage::getDriver()
//            ->readStream($song->path);
//
//       $response = response()->streamDownload(
//            function() use($stream) {
//                while(ob_get_level() > 0) ob_end_flush();
//                fpassthru($stream);
//            },
//            'stream',
//            [
//                'Content-Type' => 'audio/' . pathinfo($song->path, PATHINFO_EXTENSION),
//            ]);
//        dump($response);
//        return $response;
//        \Storage::readStream($song);
//        $streamer = new LaravelStreamer();
//        $streamer->setSong($song);
//        return $streamer->stream();

        return response()->streamDownload(function () {
            if ($stream = fopen('https://fra1.digitaloceanspaces.com/laravel-acr/where.mp3?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=DMH2UB7Z5RFOKNU2RLBJ%2F20201226%2Ffra1%2Fs3%2Faws4_request&X-Amz-Date=20201226T005113Z&X-Amz-Expires=3600&X-Amz-SignedHeaders=host&X-Amz-Signature=3425b0577b42b810f6431c7db7682caff42f94c539211a69a249140ecf725ab1', 'r')) {
                while (!feof($stream)) {
                    echo fread($stream, 2048);
                    flush();
                }
                fclose($stream);
            }
        }, 'file-name.ext');
    }
}
