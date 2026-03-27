<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the edit transaction form (TransactionController@update).
// category_id is required for expenses but optional for income (income has no category).
class UpdateTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        $isExpense = $this->route('transaction')->type === 'expense';

        return [
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'note'        => ['nullable', 'string', 'max:255'],
            'date'        => ['required', 'date'],
            'category_id' => $isExpense
                ? ['required', 'exists:categories,id']
                : ['nullable'],
        ];
    }
}
