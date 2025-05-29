<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImagesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_unit_id' => 'required|exists:product_units,id',
            'image' => 'required|string',
            'is_default' => 'required|boolean',
        ];
    }
}
