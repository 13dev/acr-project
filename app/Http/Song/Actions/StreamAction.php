<?php

namespace App\Http\Song\Actions;

use App\Core\Services\Streamers\LaravelStreamer;
use App\Core\Services\Streamers\SpacesStreamer;
use App\Core\Services\Streamers\StreamerResolver;
use App\Domain\Song\Song;
use Carbon\Carbon;
use Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class StreamAction
{

    /**
     * Stream-able file handler
     *
     * @param String $file_location
     * @param Header|String $content_type
     * @return content
     */
    function streamm($file, $size, $content_type = 'application/octet-stream') {
        // Make sure the files exists, otherwise we are wasting our time

        // Get file size
        $filesize = $size;

        // Handle 'Range' header
        if(isset($_SERVER['HTTP_RANGE'])){
            $range = $_SERVER['HTTP_RANGE'];
        }elseif($apache = apache_request_headers()){
            $headers = array();
            foreach ($apache as $header => $val){
                $headers[strtolower($header)] = $val;
            }
            if(isset($headers['range'])){
                $range = $headers['range'];
            }
            else $range = FALSE;
        } else $range = FALSE;

        //Is range
        if($range){
            $partial = true;
            list($param, $range) = explode('=',$range);
            // Bad request - range unit is not 'bytes'
            if(strtolower(trim($param)) != 'bytes'){
                header("HTTP/1.1 400 Invalid Request");
                exit;
            }
            // Get range values
            $range = explode(',',$range);
            $range = explode('-',$range[0]);
            // Deal with range values
            if ($range[0] === ''){
                $end = $filesize - 1;
                $start = $end - intval($range[0]);
            } else if ($range[1] === '') {
                $start = intval($range[0]);
                $end = $filesize - 1;
            }else{
                // Both numbers present, return specific range
                $start = intval($range[0]);
                $end = intval($range[1]);
                if ($end >= $filesize || (!$start && (!$end || $end == ($filesize - 1)))) $partial = false; // Invalid range/whole file specified, return whole file
            }
            $length = $end - $start + 1;
        }
        // No range requested
        else $partial = false;

        // Send standard headers
        header("Content-Type: $content_type");
        header("Content-Length: " . ($partial ? $length : $filesize));
        header('Accept-Ranges: bytes');

        // send extra headers for range handling...
        if ($partial) {
            header('HTTP/1.1 206 Partial Content');
            header("Content-Range: bytes $start-$end/$filesize");
            if (!$fp = fopen($file, 'rb')) {
                header("HTTP/1.1 500 Internal Server Error");
                exit;
            }
            if ($start) fseek($fp,$start);
            while($length){
                set_time_limit(0);
                $read = ($length > 8192) ? 8192 : $length;
                $length -= $read;
                print(fread($fp,$read));
            }
            fclose($fp);
        }
        //just send the whole file
        else readfile($file);
        exit;
    }

    public function __invoke(Song $song)
    {
        // Try to choose the best streamer

//        $size = Storage::disk('spaces')->getSize(config('songs.spaces_path') . $song->path);
//
////        $inputStream = Storage::disk('spaces')->getDriver()->readStream(config('songs.spaces_path') . $song->path);
////
////        Storage::disk('local')->putStream('musics/fileeee.mp3', $inputStream);
//
//        return $this->streamm(
//            Storage::disk('spaces')->temporaryUrl(config('songs.spaces_path') . $song->path, Carbon::now()->addMinutes(5)),
//            $size,
//            'audio/mpeg'
//        );
        return StreamerResolver::resolve([
            SpacesStreamer::class,
            LaravelStreamer::class,
        ], $song);
    }
}
