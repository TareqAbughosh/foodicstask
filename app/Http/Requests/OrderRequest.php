<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

     /**
     * Get custom error messages for validation failures.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'products.required' => 'The products field is required.',
            'products.array' => 'The products field must be an array.',
            'products.*.product_id.required' => 'Each product must have a valid product ID.',
            'products.*.product_id.integer' => 'Product ID must be an integer.',
            'products.*.quantity.required' => 'Each product must have a quantity.',
            'products.*.quantity.integer' => 'Quantity must be an integer.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
