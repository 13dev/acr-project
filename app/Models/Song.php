<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Song extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'title',
        'track',
        'disc',
        'length',
        'path',
        'mtime',
        'explicit',
        'compilation',
    ];

    /**
     * Format the searchable result for the model.
     *
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->title, '/albums/' . $this->album->id);
    }

    /**
     * A song belongs to an album.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getPlaytimeAttribute()
    {
        return gmdate("i:s", $this->length);

//        $minutes = floor($this->length / 60);
//
//        $seconds = $this->length - ($minutes * 60);
//
//        return Str::padLeft($minutes, 2, '0') . ':' . Str::padLeft($seconds, 2, '0');
    }
}
