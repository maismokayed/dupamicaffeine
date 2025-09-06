<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class ProductImage extends Model
{
     protected $fillable = ['product_id', 'image_path', 'alt_text', 'position'];

    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Event: عند حذف الصورة نحذف الملف من storage
    protected static function booted()
    {
        static::deleting(function ($image) {
            Storage::disk(config('filesystems.default'))->delete($image->image_path);
        });
    }
}
