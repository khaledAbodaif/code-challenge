<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'products.*.quantity' => ['required', 'numeric', 'min:1'],
//            'notes' => ['sometimes', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'Products array is required',
            'products.array' => 'Products must be an array',
            'products.*.product_id.required' => 'Product ID is required',
            'products.*.product_id.integer' => 'Product ID must be an integer',
            'products.*.product_id.exists' => 'Product ID does not exist',
            'products.*.quantity.required' => 'Quantity is required',
            'products.*.quantity.numeric' => 'Quantity must be a number',
            'products.*.quantity.min' => 'Quantity must be greater than 0',
//            'notes' => 'Notes must be less than or equal 1000',
        ];
    }
}
