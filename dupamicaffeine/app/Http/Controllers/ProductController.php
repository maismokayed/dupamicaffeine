<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images'); // جلب الصور مع المنتج

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by active
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        return ProductResource::collection($query->paginate(10));
    }

    public function store(StoreProductRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $product = Product::create($request->validated());

            // رفع الصور
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store("products/{$product->id}", config('filesystems.default'));
                    $product->images()->create([
                        'image_path' => $path,
                        'alt_text'   => null,
                        'position'   => $product->images()->count(),
                    ]);
                }
            }

            return new ProductResource($product->load('images'));
        });
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('images'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return DB::transaction(function () use ($request, $product) {
            $product->update($request->validated());

            // حذف الصور المطلوبة
            if ($request->filled('remove_image_ids')) {
                $product->images()->whereIn('id', $request->remove_image_ids)->get()->each->delete();
            }

            // إضافة صور جديدة
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store("products/{$product->id}", config('filesystems.default'));
                    $product->images()->create([
                        'image_path' => $path,
                        'alt_text'   => null,
                        'position'   => $product->images()->count(),
                    ]);
                }
            }

            return new ProductResource($product->fresh()->load('images'));
        });
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
