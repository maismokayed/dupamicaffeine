<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistRequest;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($wishlist);
    }
    public function store(WishlistRequest $request)
    {
        $wishlist = Wishlist::firstOrCreate([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'message' => 'تمت إضافة المنتج إلى قائمة الأمنيات',
            'data'    => $wishlist
        ], 201);
    }
     public function destroy($productId)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if (!$wishlist) {
            return response()->json(['message' => 'المنتج غير موجود في قائمة الأمنيات'], 404);
        }

        $wishlist->delete();

        return response()->json(['message' => 'تمت إزالة المنتج من قائمة الأمنيات']);
    }
}
