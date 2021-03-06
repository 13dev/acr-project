<?php

namespace App\Http\Song\Resources;

use App\Http\Album\Resources\AlbumResource;
use App\Http\Artist\Resources\ArtistResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'disc' => $this->disc,
            'length' => $this->length,
            'playtime' => $this->playtime,
            'path' => $this->path,
            'artist' => new ArtistResource($this->album->artist),
            'album' => new AlbumResource(
                $this->whenLoaded('album')
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
