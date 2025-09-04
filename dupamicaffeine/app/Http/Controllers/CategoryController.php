<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;


class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    //show only one
     public function show(Category $category)
    {
        return response()->json($category);
    }
    
     public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json($category);
    }
     public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
        return response()->json([
            'message' => 'لا يمكن حذف التصنيف لأنه يحتوي على منتجات مرتبطة.'
        ], 400);
    }
        $category->delete();

        return response()->json(null, 204);
    }

}
