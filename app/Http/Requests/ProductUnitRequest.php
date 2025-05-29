<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
                        'product_id' => 'required|exists:products,id',
            'unit_price' => 'required',
            'total_price' => 'required',
            'quantity' => 'required',
            'conversion_factor' => 'required',
            'unit_id' => 'nullable|exists:units,id',
            'brand_id' => 'nullable|exists:brands,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'product_images' => 'nullable|array',
            'product_images.*' => 'required|array',
            'product_images.*.image' => 'required|string',
            'product_images.*.is_default' => 'required|boolean',
        ];
    }
}
