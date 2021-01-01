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
//
//        $inputStream = Storage::disk('spaces')->getDriver()->read(config('songs.spaces_path') . $this->song->path);
//        $filename = Str::uuid() . '.mp3';
//        $tempMusic = tempnam(sys_get_temp_dir(), $filename);
//        Storage::disk('local')->put($tempMusic, $inputStream);
//
//        Storage::download()
//
//
////
////        $filePath = config('songs.spaces_path') . $this->song->path;
////        $stream = $disk->readStream($filePath);
//
//        return response()->download($tempMusic, $filename, [
//            'Accept-Ranges' => 'bytes 0/' . Storage::disk('spaces')->size(config('songs.spaces_path') . $this->song->path),
//            'Content-Type' => 'audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3',
//            'Content-Range' => '0-' . Storage::disk('spaces')->size(config('songs.spaces_path') . $this->song->path),
//            'X-Pad' => 'avoid browser bug',
//            'Cache-Control' => 'no-cache',
//        ])->deleteFileAfterSend();
//
        return Storage::disk('spaces')->download(config('songs.spaces_path') . $this->song->path, null, [
            'Accept-Ranges' =>'bytes'
        ]);

//        $disk = Storage::disk('spaces');
//        $filePath = config('songs.spaces_path') . $this->song->path;
//
//        return $disk->response($filePath, null, [
//            'Content-Range' => '0-' . $disk->size($filePath),
//            'Content-Type' => 'audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3',
//            'X-Pad' => 'avoid browser bug',
//            'Cache-Control' => 'no-cache',
//        ]);


//        $stream = $storage
//            ->readStream();
//
//       return response()->streamDownload(
//            function() use($stream) {
//                while(ob_get_level() > 0) ob_end_flush();
//                fpassthru($stream);
//            },
//            'stream',
//            [
//                'Content-Type' => 'audio/' . pathinfo($this->song->path, PATHINFO_EXTENSION),
//            ]);


//
//        $storage->writeStream(config('songs.path'), $storage->readStream(config('songs.spaces_path') . $this->song->path));
//
//        return \response()->download($storage->get(config('songs.path') . $this->song->path));
    }
}
