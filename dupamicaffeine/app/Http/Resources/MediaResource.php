<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'             => $this->name,
            'url'              => $this->getUrl(),
            'mime_type'        => $this->mime_type,
            'size'             => $this->size,
            'collection_name'  => $this->collection_name,
            'order_column'     => $this->order_column,
            'responsive_images'=> $this->responsive_images,
        ];
    }
}
