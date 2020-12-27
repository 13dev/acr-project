<?php

namespace App\Http\Song;

use App\Core\Controller;
use App\Domain\Song\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use App\Core\Services\Youtube\Facades\YoutubeDownload;

class StreamController extends Controller
{
    public function show(Request $request, Song $song)
    {
//        $stream = Storage::getDriver()->readStream($song->path);
//        $response = response()->streamDownload(
//            function () use ($stream) {
//                while (ob_get_level() > 0) ob_end_flush();
//                fpassthru($stream);
//            },
//            'stream',
//            [
//                'Content-Type' => 'audio/' . pathinfo($song->path, PATHINFO_EXTENSION),
//            ]);
//        return $response;

//       return $response;
//        dump($response);
//        return $response;
//        \Storage::readStream($song);

        return response()->download(storage_path('app/' . $song->path), null, [
            'Content-Type' => 'audio/mpeg'
        ]);
//        $streamer = new LaravelStreamer();
//        $streamer->setSong($song);
//
//
//        return $streamer->stream();

    }
}
