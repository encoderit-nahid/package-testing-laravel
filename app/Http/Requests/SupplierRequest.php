<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'contact_person' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ];
    }
}
