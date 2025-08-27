<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'product'  => [
                'id'   => $this->product_id,
                'name' => $this->whenLoaded('product', fn () => $this->product->name),
            ],
            'quantity' => $this->quantity,
            'price'    => $this->price_at_added_time,
            'subtotal' => $this->quantity * $this->price_at_added_time,
        ];
    }
}
