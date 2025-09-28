<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class SaleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all authenticated users to submit sales
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.product_id' => 'required|array|min:1',
            'items.product_id.*' => 'required|integer|min:1|exists:products,id',
            'items.quantity.*' => 'required|integer|min:1',
            'items.price.*' => 'required|numeric|min:0',
            'items.discount.*' => 'nullable|numeric|min:0|max:100', // percentage
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'sale_date.required' => 'Sale date is required.',
            'items.required' => 'At least one product must be added.',
            'items.product_id.*.required' => 'Product selection is required.',
            'items.product_id.required' => 'Product selection is required.',
            'items.quantity.*.required' => 'Quantity is required for each product.',
            'items.price.*.required' => 'Price must be set for each product.',
            'items.discount.*.max' => 'Discount cannot exceed 100%.',
        ];
    }
}
