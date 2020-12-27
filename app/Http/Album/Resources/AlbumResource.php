<?php

namespace App\Http\Album\Resources;

use App\Http\Song\Resources\SongResource;
use App\Http\Artist\Resources\ArtistResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'genre' => $this->genre,
            'cover' => 'storage/covers/' . $this->cover,
            'playtime' => $this->playtime,
            'artist' => new ArtistResource(
                $this->whenLoaded('artist')
            ),
            'songs' => SongResource::collection(
                $this->whenLoaded('songs')
            ),
        ];
    }
}
