<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
