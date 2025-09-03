<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
     public function store(ProductReviewRequest $request)
    {
        $review = ProductReview::create([
            'user_id'    => auth()->id(), // المستخدم الحالي
            'product_id' => $request->product_id,
            'rating'     => $request->rating,
        ]);

        return response()->json([
            'message' => 'تم إضافة التقييم بنجاح',
            'data'    => $review
        ], 201);
    }
}
