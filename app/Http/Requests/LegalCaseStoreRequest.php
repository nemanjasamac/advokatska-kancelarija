<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegalCaseStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'case_type' => ['required', 'string'],
            'court' => ['nullable', 'string'],
            'opponent' => ['nullable', 'string'],
            'status' => ['required', 'in:novi,otvoren,u_toku,na_cekanju,zatvoren'],
            'opened_at' => ['required', 'date'],
            'closed_at' => ['nullable', 'date'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
