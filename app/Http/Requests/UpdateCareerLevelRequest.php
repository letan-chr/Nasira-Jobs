<?php

namespace App\Http\Requests;

use App\Models\CareerLevel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCareerLevelRequest extends FormRequest
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
        $rules = CareerLevel::$rules;
        $rules['level_name'] = 'required|max:150|unique:career_levels,level_name,'.$this->route('careerLevel')->id;

        return $rules;
    }
}
