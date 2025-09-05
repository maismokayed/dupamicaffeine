<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

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
    $product = Product::create($request->validated());
    return new ProductResource($product);
}

public function show(Product $product)
{
    return new ProductResource($product);
}

public function update(UpdateProductRequest $request, Product $product)
{
    $product->update($request->validated());
    return new ProductResource($product);
}

public function destroy(Product $product)
{
    $product->delete();
    return response()->json(['message' => 'Product deleted successfully.']);
}

}
