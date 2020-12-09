<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\SongResource;

class SongController extends Controller
{
    public function index()
    {
        return SongResource::collection(Song::all());
    }
}
