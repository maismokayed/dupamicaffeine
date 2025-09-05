<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    //admin
     public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return CouponResource::collection($coupons);
    }
 public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create($request->validated());

        return response()->json([
            'message' => 'تم إنشاء الكوبون بنجاح',
            'data'    => $coupon
        ], 201);
    }
    public function show(Coupon $coupon)
    {
        return new CouponResource($coupon);

    }
 public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return response()->json([
    'message' => 'تم تحديث الكوبون بنجاح',
    'data'    => new CouponResource($coupon)
]);
    }
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json(['message' => 'تم حذف الكوبون بنجاح']);
    }
   //user
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:coupons,code',
        ], [
            'code.required' => 'الكود مطلوب',
            'code.exists'   => 'الكوبون غير موجود',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        // تحقق من صلاحية الكوبون
        if (!$coupon->is_active) {
            return response()->json(['message' => 'الكوبون غير مفعل'], 400);
        }

        if ($coupon->expires_at && Carbon::now()->greaterThan($coupon->expires_at)) {
            return response()->json(['message' => 'الكوبون منتهي الصلاحية'], 400);
        }

        return response()->json([
    'message' => 'الكوبون صالح',
    'data'    => new CouponResource($coupon)
]);
    }
}
