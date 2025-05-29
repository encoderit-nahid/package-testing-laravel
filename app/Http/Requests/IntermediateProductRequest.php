<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntermediateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'yield' => 'required',
        ];
    }
}
