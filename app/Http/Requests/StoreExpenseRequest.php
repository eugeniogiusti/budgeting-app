<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the new expense form (TransactionController@store).
// category_id must reference an existing category (non-goal).
class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'category_id' => ['required', 'exists:categories,id'],
            'date'        => ['required', 'date'],
            'note'        => ['nullable', 'string', 'max:255'],
            'receipt'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
