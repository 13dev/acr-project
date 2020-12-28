<?php


namespace App\Http\Song\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayedSongResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'times' => $this->times,
            'song' => new SongResource($this->song),
        ];
    }
}
