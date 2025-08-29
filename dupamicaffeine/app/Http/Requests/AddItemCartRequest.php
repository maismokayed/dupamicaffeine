<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemCartRequest extends FormRequest
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
        
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
      public function messages()
    {
        return [
            'cart_id.required' => 'معرّف العربة (cart_id) مطلوب',
            'cart_id.exists' => 'العربة المحددة غير موجود',
            'product_id.required' => 'معرّف المنتج (product_id) مطلوب',
            'product_id.exists' => 'المنتج المحدد غير موجود',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.integer' => 'الكمية يجب أن تكون رقم صحيح',
            'quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
        ];
    }
}
