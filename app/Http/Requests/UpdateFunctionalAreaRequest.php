<?php

namespace App\Http\Requests;

use App\Models\FunctionalArea;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFunctionalAreaRequest extends FormRequest
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
        $rules = FunctionalArea::$rules;
        $rules['name'] = 'required|max:150|unique:functional_areas,name,'.$this->route('functionalArea')->id;

        return $rules;
    }
}
