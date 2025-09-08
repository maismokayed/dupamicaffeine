<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\Wishlist;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\ProductReview;

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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
 public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }
    
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
  }