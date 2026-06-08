<?php

namespace App\Http\Requests;

use App\Models\Attendee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterAttendeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $eventId = $this->route('id');

        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email: rfc,dns',
                Rule::unique('attendees')->where(function ($query) use ($eventId) {
                    return $query->where('event_id', $eventId);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'A név kötelező.',
            'name.string'     => 'A név szöveges érték kell legyen.',
            'email.required'  => 'Az email cím kötelező.',
            'email.email'     => 'Az email cím formátuma érvénytelen.',
            'email.unique'    => 'Ez az email cím már regisztrált erre az eseményre.',
        ];
    }
}
