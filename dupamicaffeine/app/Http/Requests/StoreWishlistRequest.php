<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWishlistRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
        ];
    }
     public function messages()
    {
        return [
            'user_id.required' => 'معرّف المستخدم (user_id) مطلوب',
            'user_id.exists' => 'المستخدم المحدد غير موجود',
            'product_id.required' => 'معرّف المنتج (product_id) مطلوب',
            'product_id.exists' => 'المنتج المحدد غير موجود',
        ];
    }
}
