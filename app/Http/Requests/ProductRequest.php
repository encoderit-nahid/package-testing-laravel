<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'is_active' => 'required|boolean',
            'is_default' => 'required|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',

            'product_units' => 'nullable|array',
            'product_units.*' => 'required|array',
            'product_units.*.unit_price' => 'required',
            'product_units.*.total_price' => 'required',
            'product_units.*.quantity' => 'required',
            'product_units.*.conversion_factor' => 'required',
            'product_units.*.unit_id' => 'nullable|exists:units,id',
            'product_units.*.brand_id' => 'nullable|exists:brands,id',
            'product_units.*.supplier_id' => 'nullable|exists:suppliers,id',

            'product_units.*.product_images' => 'nullable|array',
            'product_units.*.product_images.*' => 'required|array',
            'product_units.*.product_images.*.image' => 'required|string',
            'product_units.*.product_images.*.is_default' => 'required|boolean',
        ];
    }
}
