<?php

namespace App\Http\Requests;

use App\Models\MaritalStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMaritalStatusRequest extends FormRequest
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
        $maritalStatus = $this->route('maritalStatus');
        $rules = MaritalStatus::$rules;
        $rules['marital_status'] = 'required|max:150|unique:marital_status,marital_status,'.$maritalStatus->id;

        return $rules;
    }
}
