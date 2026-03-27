<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validates the CSV import form (ImportController@store).
// Rules are conditional on mode: 'paste' expects raw text content, 'file' expects a csv/txt upload (max 2MB).
class ImportCsvRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->input('mode') === 'paste') {
            return [
                'content' => ['required', 'string'],
            ];
        }

        return [
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ];
    }
}
