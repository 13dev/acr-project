<?php


namespace App\Http\Search\Actions;


use App\Domain\Album\Album;
use App\Domain\Song\Song;
use App\Domain\Artist\Artist;
use App\Http\Search\Resources\SearchResource;
use Spatie\Searchable\Search;

class GlobalSearchAction
{
    public function __invoke($query = '')
    {
        $results = (new Search)
            ->registerModel(Artist::class, ['name'])
            ->registerModel(Album::class, ['name'])
            ->registerModel(Song::class, ['title'])
            ->search($query);

        return SearchResource::collection($results);
    }
}
