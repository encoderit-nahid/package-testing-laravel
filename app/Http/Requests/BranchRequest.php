<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'is_commissary' => 'required|boolean',
            'code' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
            'is_active' => 'required|boolean',
            'is_default' => 'required|boolean',
            'logo' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
