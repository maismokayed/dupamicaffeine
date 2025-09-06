<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
      protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'is_active'

    ];
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }
    
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
  }