<?php

namespace App\Http\Requests;

use App\Models\RequiredDegreeLevel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequiredDegreeLevelRequest extends FormRequest
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
        $rules = RequiredDegreeLevel::$rules;
        $rules['name'] = 'required|max:160|unique:required_degree_levels,name,'.$this->route('requiredDegreeLevel')->id;

        return $rules;
    }
}
