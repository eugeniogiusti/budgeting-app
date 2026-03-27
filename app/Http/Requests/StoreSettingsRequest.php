<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the settings form (SettingsController@update).
// Accepted values are driven by config/budget.php → locales / currencies.
class StoreSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'locale'   => ['required', 'in:' . implode(',', array_keys(config('budget.locales')))],
            'currency' => ['required', 'in:' . implode(',', array_keys(config('budget.currencies')))],
        ];
    }
}
