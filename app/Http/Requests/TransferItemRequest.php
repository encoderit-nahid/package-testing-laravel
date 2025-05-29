<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transfer_id' => 'required|exists:transfers,id',
            'product_id' => 'required|exists:products,id',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required',
            'unit_price' => 'required',
        ];
    }
}
