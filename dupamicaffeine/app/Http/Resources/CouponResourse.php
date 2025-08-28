<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'code'          => $this->code,
            'description'   => $this->description,
            'discount_type' => $this->discount_type,
            'discount_value'=> $this->discount_value,
            'expires_at'    => $this->expires_at?->format('Y-m-d H:i'),
            'is_active'     => (bool) $this->is_active,
        ];
    }
}
