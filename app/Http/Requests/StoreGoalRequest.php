<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the create/update goal form (GoalController@store / @update).
// target_date is optional but must be in the future if provided.
class StoreGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'emoji'         => ['required', 'string', 'max:10'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'target_date'   => ['nullable', 'date', 'after:today'],
            'color'         => ['nullable', 'string', 'max:7'],
        ];
    }
}
