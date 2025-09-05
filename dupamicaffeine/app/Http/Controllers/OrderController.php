<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1) إنشاء طلب جديد
    public function store(StoreOrderRequest $request)
    {
        $user = $request->user();
        $cartItems = DB::table('cart_items')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'السلة فارغة'], 422);
        }

        // نستخدم Transaction لضمان سلامة العملية
        $order = DB::transaction(function () use ($request, $cartItems, $user) {
            $total = 0;

            // حساب المجموع والتحقق من المخزون
            foreach ($cartItems as $ci) {
                $product = Product::lockForUpdate()->findOrFail($ci->product_id);

                if ($product->stock < $ci->quantity) {
                    throw new \Exception("الكمية غير متوفرة للمنتج {$product->name}");
                }

                $lineTotal = $product->price * $ci->quantity;
                $total += $lineTotal;

                // نقص من المخزون
                $product->decrement('stock', $ci->quantity);
            }

            // حساب الخصم لو فيه كوبون
            $discount = 0;
            if ($request->coupon_id) {
                $coupon = Coupon::findOrFail($request->coupon_id);

                if ($coupon->type === 'percent') {
                    $discount = round($total * ($coupon->value / 100), 2);
                } else {
                    $discount = min($total, $coupon->value);
                }
            }

            $final = $total - $discount;

            // إنشاء الطلب
            $order = Order::create([
                'user_id'         => $user->id,
                'coupon_id'       => $request->coupon_id,
                'total_amount'    => $total,
                'discount_amount' => $discount,
                'final_amount'    => $final,
                'status'          => 'pending',
                'note'            => $request->note,
            ]);

            // إنشاء العناصر (order_items)
            foreach ($cartItems as $ci) {
                $product = Product::find($ci->product_id);

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'unit_price'   => $product->price,
                    'quantity'     => $ci->quantity,
                    'total_price'  => $product->price * $ci->quantity,
                ]);
            }

            // تنظيف السلة
            DB::table('cart_items')->where('user_id', $user->id)->delete();

            return $order;
        });

        return response()->json([
            'message' => 'تم إنشاء الطلب بنجاح',
            'data'    => $order->load('items'),
        ], 201);
    }

    // 2) عرض الطلبات الخاصة باليوزر
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'تم جلب الطلبات بنجاح',
            'data'    => $orders,
        ]);
    }
    // عرض الطلبات للادمن
    public function indexAdmin()
{
    $orders = Order::with(['user', 'coupon'])->latest()->get();

    return response()->json([
        'message' => 'جميع الطلبات',
        'data'    => $orders
    ]);
}

    // 3) تحديث حالة الطلب (للأدمن فقط)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'data'    => $order
        ]);
    }
}
