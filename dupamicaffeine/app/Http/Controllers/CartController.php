<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Requests\AddItemCartRequest;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show($cartId)
    {
        $cart = Cart::with('items.product')->findOrFail($cartId);
        return new CartResource($cart);
    }

    public function addOrUpdate(AddItemCartRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($data['product_id']);

            if ($data['quantity'] > $product->stock) {
                return response()->json([
                    'error' => 'الكمية المطلوبة غير متوفرة. المتاح فقط: ' . $product->stock
                ], 400);
            }

            $cart = $data['cart_id']
                ? Cart::find($data['cart_id'])
                : Cart::create();

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
