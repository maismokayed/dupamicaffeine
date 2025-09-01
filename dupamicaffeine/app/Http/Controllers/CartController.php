<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
      public function show($cartId)
    {
        $cart = Cart::with('items.product')->findOrFail($cartId);

        return response()->json([
            'cart_id' => $cart->id,
            'items' => $cart->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->quantity * $item->product->price,
                ];
            }),
            'cart_total' => $cart->items->sum(fn($item) => $item->quantity * $item->product->price)
        ]);
    }

    public function addOrUpdate(Request $request)
{
    $data = $request->validate([
        'cart_id' => 'nullable|exists:carts,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        //  تحقق من وجود المنتج
        $product = Product::findOrFail($data['product_id']);

        //  تحقق من المخزون
        if ($data['quantity'] > $product->stock) {
            return response()->json([
                'error' => 'الكمية المطلوبة غير متوفرة. المتاح فقط: ' . $product->stock . ' قطع'
            ], 400); // 400 Bad Request
        }

        // إذا ما في cart_id نعمل عربة جديدة
        $cart = $data['cart_id'] 
            ? Cart::find($data['cart_id']) 
            : Cart::create();

        // تحقق إذا المنتج موجود بالفعل في العربة
        $cartItem = $cart->items()->where('product_id', $data['product_id'])->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $data['quantity']]);
        } else {
            $cart->items()->create([
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'تمت إضافة/تحديث المنتج في العربة بنجاح',
            'cart_id' => $cart->id
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'حدث خطأ: '.$e->getMessage()], 500);
    }

   public function removeItem($cartId, $productId)
{
    $cart = Cart::findOrFail($cartId);

    $item = $cart->items()->where('product_id', $productId)->first();

    if (!$item) {
        return response()->json(['message' => 'المنتج غير موجود في العربة'], 404);
    }

    $item->delete();

    return response()->json(['message' => 'تمت إزالة المنتج من العربة']);
}

}


    
