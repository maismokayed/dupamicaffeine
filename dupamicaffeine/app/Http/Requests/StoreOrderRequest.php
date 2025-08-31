<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        return [
             'user_id' => 'required|exists:users,id',
            'coupon_id' => 'nullable|exists:coupons,id',
            'total_amount' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'final_amount' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(['pending','processing','completed','cancelled'])],
            'note' => 'nullable|string',
        ];
    }
       public function messages()
    {
        return [
            'user_id.required' => 'معرّف المستخدم (user_id) مطلوب',
            'user_id.exists' => 'المستخدم المحدد غير موجود',
            'coupon_id.exists' => 'الكوبون المحدد غير موجود',
            'total_amount.required' => 'المبلغ الإجمالي (total_amount) مطلوب',
            'total_amount.numeric' => 'المبلغ الإجمالي يجب أن يكون رقم',
            'total_amount.min' => 'المبلغ الإجمالي يجب أن يكون 0 أو أكثر',
            'discount_amount.required' => 'مبلغ الخصم (discount_amount) مطلوب',
            'discount_amount.numeric' => 'مبلغ الخصم يجب أن يكون رقم',
            'discount_amount.min' => 'مبلغ الخصم يجب أن يكون 0 أو أكثر',
            'final_amount.required' => 'المبلغ النهائي (final_amount) مطلوب',
            'final_amount.numeric' => 'المبلغ النهائي يجب أن يكون رقم',
            'final_amount.min' => 'المبلغ النهائي يجب أن يكون 0 أو أكثر',
            'status.required' => 'حالة الطلب (status) مطلوبة',
            'status.in' => 'حالة الطلب غير صحيحة',
            'note.string' => 'الملاحظة يجب أن تكون نص',
        ];
    }
}
