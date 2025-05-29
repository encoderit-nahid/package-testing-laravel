<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitConversionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_unit_id' => 'required|exists:units,id',
            'to_unit_id' => 'required|exists:units,id',
            'multiplier' => 'required',
        ];
    }
}
