<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    //show only one
     public function show(Category $category)
    {
        return response()->json($category);
    }
    
     public function update(UpdateCategoryRequest $request, Category $category)
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

        return response()->json([
    'message' => 'تم حذف التصنيف بنجاح',
    'id'      => $category->id
], 200);
    }

}
