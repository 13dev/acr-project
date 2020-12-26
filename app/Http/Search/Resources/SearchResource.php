<?php

namespace App\Http\Search\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray($request)
    {
        return (array) $this;
    }
}
