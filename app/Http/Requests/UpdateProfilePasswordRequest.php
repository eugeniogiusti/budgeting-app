<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

// Validates the change-password form (ProfileController@updatePassword).
// 'current_password' rule verifies the hash against the authenticated user's stored password.
class UpdateProfilePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ];
    }
}
