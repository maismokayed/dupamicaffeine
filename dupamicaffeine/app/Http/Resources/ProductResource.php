<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          return [
            'id'             => $this->id,
            'category_id'    => $this->category_id,
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => (float) $this->price,
            'stock_quantity' => $this->stock_quantity,
            'added_on'       => $this->created_at ? $this->created_at->format('Y-m-d H:i') : null,
            'in_wishlist' => auth()->check() 
                   ? $this->wishlists()->where('user_id', auth()->id())->exists() 
                   : false,
            'images'      => $this->images->map(function ($img) {
                return [
                    'id'       => $img->id,
                    'url'      => Storage::disk(config('filesystems.default'))->url($img->image_path),
                    'alt'      => $img->alt_text,
                    'position' => $img->position,
                ];
            }),
        ];
    }
}

