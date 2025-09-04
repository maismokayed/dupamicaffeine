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
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
