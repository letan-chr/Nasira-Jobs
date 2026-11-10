<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
        $rules = [
            'first_name' => 'required|max:180',
            'last_name' => 'required|max:180',
            'email' => 'required|email|unique:users,email,|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/',
            'phone' => 'nullable',
            'password' => 'required|min:8|same:cpassword',
            'cpassword' => 'required|min:8',
            'profile' => 'nullable|mimes:jpeg,jpg,png',
            'role' => 'required|string|exists:roles,name|not_in:Employer,Candidate',
        ];

        return $rules;
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'password.same' => __('messages.password_mismatch'),
        ];
    }
}
