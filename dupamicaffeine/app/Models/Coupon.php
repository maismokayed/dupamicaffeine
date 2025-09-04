<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
        protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'expires_at',
        'is_active',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
