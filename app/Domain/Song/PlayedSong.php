<?php

namespace App\Domain\Song;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayedSong extends Model
{
    use HasFactory;

    protected $fillable = [
        'times',
        'song_id'
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
