<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateUpdateGeneralInformationRequest extends FormRequest
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
            'candidateSkills' => 'required',
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'phone' => 'nullable|min:10|max:10',
        ];
    }
}
