<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CmsServiceRequest extends FormRequest
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
            'home_title' => 'required',
            'home_description' => 'required',
            'home_banner' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }
}
