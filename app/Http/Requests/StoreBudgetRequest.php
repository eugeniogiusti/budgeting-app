<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the monthly budget limit form (BudgetController@store / @update).
class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0'],
            'year'   => ['required', 'integer'],
            'month'  => ['required', 'integer', 'min:1', 'max:12'],
        ];
    }
}
