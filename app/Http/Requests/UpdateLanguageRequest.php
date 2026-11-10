<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
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
        $rules['language'] = 'required|max:150|unique:languages,language,'.$this->route('language')->id;
        $rules['iso_code'] = 'required|max:150|unique:languages,iso_code,'.$this->route('language')->id;

        return $rules;
    }

    public function messages(): array
    {
        $messages['iso_code.required'] = __('messages.iso_code_required');

        return $messages;
    }
}
