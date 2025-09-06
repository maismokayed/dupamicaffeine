<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;


class ProductImage extends Model
{
     protected $fillable = ['product_id', 'image_path'];

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
