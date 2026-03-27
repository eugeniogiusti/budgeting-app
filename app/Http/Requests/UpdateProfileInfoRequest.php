<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

// Validates the profile name/email form (ProfileController@updateInfo).
// The unique rule excludes the current user to allow saving without changing email.
class UpdateProfileInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ];
    }
}
