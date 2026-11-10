<?php

namespace App\Http\Requests;

use App\Models\CandidateEducation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateCandidateEducationRequest
 */
class CreateCandidateEducationRequest extends FormRequest
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
        return CandidateEducation::$rules;
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'country_id.required' => __('messages.country_id_required'),
        ];
    }
}
