<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $merge = [];
        foreach (['email', 'password', 'password_confirmation', 'ceo', 'location', 'website', 'details'] as $field) {
            if ($this->has($field) && $this->input($field) === '') {
                $merge[$field] = null;
            }
        }
        if ($merge !== []) {
            $this->merge($merge);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = Company::$rules;
        $rules['name'] = 'required|max:180';
        $rules['email'] = 'nullable|email:filter|unique:users,email';
        $rules['password'] = 'nullable|same:password_confirmation|min:8';
        $rules['phone'] = 'nullable';
        $rules['image'] = 'nullable|mimes:jpg,jpeg,png';

        return $rules;
    }
}
