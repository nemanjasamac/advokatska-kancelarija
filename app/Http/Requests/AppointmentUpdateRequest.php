<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'date_time' => ['required'],
            'type' => ['required', 'in:sastanak,rociste'],
            'location' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'legal_case_id' => ['nullable', 'integer', 'exists:legal_cases,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
