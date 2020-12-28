<?php

namespace App\Http\Artist\Resources;

use App\Http\Album\Resources\AlbumResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image ?? '',
            'albums' => AlbumResource::collection(
                $this->whenLoaded('albums')
            ),
        ];
    }
}
