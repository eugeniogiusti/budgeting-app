<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'emoji' => ['required', 'string', 'max:10'],
            'color' => ['nullable', 'string', 'max:7'],
        ];
    }
}
