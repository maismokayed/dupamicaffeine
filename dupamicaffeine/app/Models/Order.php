<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
       protected $fillable = [
        'user_id',
        'coupon_id',
        'total_amount',
        'discount_amount',
        'final_amount',
        'status',
        'note',
    ];
}
