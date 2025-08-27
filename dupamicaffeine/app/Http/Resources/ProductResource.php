<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'is_active'      => (bool) $this->is_active,
            'added_on'       => $this->created_at ? $this->created_at->format('Y-m-d H:i') : null,
        ];
    }
}
