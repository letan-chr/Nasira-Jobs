<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = Company::$rules;
        $rules['name'] = 'required|max:180';
        $rules['email'] = 'nullable|email:filter|unique:users,email,'.$this->input('user_id');
        $rules['password'] = 'nullable|same:password_confirmation|min:8';
        $rules['phone'] = 'nullable';
        $rules['image'] = 'nullable|mimes:jpeg,jpg,png';

        return $rules;
    }
}
