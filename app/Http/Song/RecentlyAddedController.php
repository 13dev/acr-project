<?php

namespace App\Http\Song;

use App\Core\Controller;
use App\Http\Song\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\Request;

class RecentlyAddedController extends Controller
{
    public function index()
    {
        $songs = Song::orderBy('album_id', 'desc')
            ->orderBy('track')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->with('album')
            ->get();

        return SongResource::collection($songs);
    }
}
