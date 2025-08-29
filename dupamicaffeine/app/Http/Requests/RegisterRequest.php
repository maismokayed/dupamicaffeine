<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
       protected function prepareForValidation(): void
    {
        $this->merge([
            'name'  => is_string($this->name) ? trim($this->name) : $this->name,
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
            'phone' => is_string($this->phone) ? preg_replace('/\s+/', '', $this->phone) : $this->phone,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'phone'                 => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,phone',
            'password'              => 'required|string|min:8|confirmed',
        ];
    }

     public function messages(): array
    {
        return [
            'name.required'      => 'حقل الاسم مطلوب.',
            'email.required'     => 'حقل البريد الإلكتروني مطلوب.',
            'email.unique'       => 'هذا البريد مستخدم مسبقاً.',
            'phone.required'     => 'رقم الهاتف مطلوب.',
            'phone.regex'        => 'رقم الهاتف يجب أن يحتوي فقط على أرقام (10–15 رقم).',
            'phone.unique'       => 'رقم الهاتف مستخدم مسبقاً.',
            'password.required'  => 'كلمة السر مطلوبة.',
            'password.min'       => 'كلمة السر يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة السر لا يطابق.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'password' => 'كلمة السر',
            'password_confirmation' => 'تأكيد كلمة السر',
        ];
    }
}
