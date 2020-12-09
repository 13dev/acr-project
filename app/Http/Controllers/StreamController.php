<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Services\Streamers\LaravelStreamer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StreamController extends Controller
{
    public function show(Request $request, Song $song)
    {
        $streamer = new LaravelStreamer();
        $streamer->setSong($song);
        return $streamer->stream();
    }
}
