<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'track' => $this->track,
            'disc' => $this->disc,
            'length' => $this->length,
            'playtime' => $this->playtime,
            'path' => $this->path,
            'mtime' => $this->mtime,
            'artist' => new ArtistResource($this->album->artist),
            'album' => new AlbumResource(
                $this->whenLoaded('album')
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
