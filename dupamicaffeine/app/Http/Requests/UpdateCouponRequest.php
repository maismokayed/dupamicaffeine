<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         $couponId = $this->route('coupon'); // Assuming route parameter is {coupon}
        return [
             'code' => ['required','string','max:50',Rule::unique('coupons','code')->ignore($couponId)],
            'description' => 'nullable|string',
            'discount_type' => ['required', Rule::in(['percentage','fixed'])],
            'discount_value' => 'required|numeric|min:0',
            'used_count' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'معرّف الكوبون (code) مطلوب',
            'code.max' => 'الكود يجب أن لا يتجاوز 50 حرف',
            'code.unique' => 'الكود مستخدم مسبقًا',
            'description.string' => 'الوصف يجب أن يكون نص',
            'discount_type.required' => 'نوع الخصم (discount_type) مطلوب',
            'discount_type.in' => 'نوع الخصم غير صحيح',
            'discount_value.required' => 'قيمة الخصم (discount_value) مطلوبة',
            'discount_value.numeric' => 'قيمة الخصم يجب أن تكون رقم',
            'discount_value.min' => 'قيمة الخصم يجب أن تكون 0 أو أكثر',
            'used_count.integer' => 'عدد مرات الاستخدام يجب أن يكون رقم صحيح',
            'used_count.min' => 'عدد مرات الاستخدام يجب أن يكون 0 أو أكثر',
            'expires_at.date' => 'تاريخ انتهاء الصلاحية غير صحيح',
            'is_active.boolean' => 'حالة التفعيل يجب أن تكون true أو false',
        ];
    }
}
