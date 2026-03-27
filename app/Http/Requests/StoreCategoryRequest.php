<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the create/update category form (CategoryController@store / @update).
// color is optional (hex, max 7 chars e.g. #ff0000); if omitted the UI uses a default.
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
