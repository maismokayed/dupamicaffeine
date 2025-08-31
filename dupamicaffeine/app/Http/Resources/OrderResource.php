<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'              => $this->id,
            'coupon_id'       => $this->coupon_id,
            'total_amount'    => $this->total_amount,
            'discount_amount' => $this->discount_amount,
            'final_amount'    => $this->final_amount,
            'status'          => $this->status,
            'note'            => $this->note,
            'created_at'      => $this->created_at?->format('Y-m-d H:i'),
            'items'           => OrderItemsResource::collection($this->whenLoaded('items')),
        ];
    }
}
