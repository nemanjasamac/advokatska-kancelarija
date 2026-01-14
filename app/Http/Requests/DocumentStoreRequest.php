<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentStoreRequest extends FormRequest
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
            'file_name' => ['required', 'string'],
            'file_path' => ['required', 'string'],
            'document_type' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'uploaded_at' => ['required'],
            'legal_case_id' => ['required', 'integer', 'exists:legal_cases,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
