<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'locale'   => ['required', 'in:' . implode(',', config('budget.locales'))],
            'currency' => ['required', 'in:' . implode(',', config('budget.currencies'))],
        ];
    }
}
