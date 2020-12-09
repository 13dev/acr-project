<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Artist extends Model implements Searchable
{
    use HasFactory;

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->name, '/artists/' . $this->getKey());
    }

    /**
     * An artist has many albums.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(Album::class)->orderBy('year', 'desc');
    }

    /**
     * An artist has many songs through albums.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function songs()
    {
        return $this->hasManyThrough(Song::class, Album::class);
    }
}
