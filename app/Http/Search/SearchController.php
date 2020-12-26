<?php

namespace App\Http\Search;

use App\Core\Controller;
use App\Domain\Album\Album;
use App\Domain\Song\Song;
use App\Domain\User\Artist;
use App\Http\Search\Resources\SearchResource;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function index($query = '')
    {
        $results = (new Search)
            ->registerModel(Artist::class, ['name'])
            ->registerModel(Album::class, ['name'])
            ->registerModel(Song::class, ['title'])
            ->search($query);

        return SearchResource::collection($results);
    }
}
