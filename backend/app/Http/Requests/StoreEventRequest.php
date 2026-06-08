<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => ['required', 'max:255'],
            'date'     => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Az esemény címe kötelező.',
            'date.required'  => 'Az esemény dátuma kötelező.',
        ];
    }
}
