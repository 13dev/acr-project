<?php

namespace App\Domain\Album;

use App\Domain\Song\Song;
use App\Domain\User\Artist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Album extends Model implements Searchable
{
    use HasFactory;

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->name, '/albums/' . $this->getKey());
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class)
            ->orderBy('disc')
            ->orderBy('track');
    }

    public function getPlaytimeAttribute()
    {
        if($this->relationLoaded('songs')) {
            $allSongsLength = $this->songs->sum(fn ($song) => $song->length);
            return gmdate("i:s", $allSongsLength);
        }

        return 0;
    }
}
