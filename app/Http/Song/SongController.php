<?php

namespace App\Http\Song;

use App\Core\Controller;
use App\Domain\Song\Song;
use App\Http\Song\Resources\SongResource;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        return SongResource::collection(Song::all());
    }
}
