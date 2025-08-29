<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

     protected function prepareForValidation(): void
    {
        $this->merge([
            'name'        => is_string($this->name) ? trim($this->name) : $this->name,
            'description' => is_string($this->description) ? trim($this->description) : $this->description,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'     => 'sometimes|exists:categories,id',
            'name'            => 'sometimes|string|max:150',
            'description'     => 'nullable|string',
            'price'           => 'sometimes|numeric|min:0',
            'stock_quantity'  => 'sometimes|integer|min:0',
            'is_active'       => 'sometimes|boolean',
        ];
    }
}
