<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required',
            'unit_price' => 'required',
            'total_price' => 'required',
        ];
    }
}
