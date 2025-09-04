<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; 
use App\Models\Cart; 

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price_at_added_time',
    ];
public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
