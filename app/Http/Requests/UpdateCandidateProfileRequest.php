<?php

namespace App\Http\Requests;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateProfileRequest extends FormRequest
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
     *
     * @return array The given data was invalid.
     */
    public function rules(): array
    {
        $id = Auth::user()->id;
        $rules = [
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'email' => 'required|email|unique:users,email,'.$id.'|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/',
            'phone' => 'nullable|min:10|max:10',
            'image' => 'nullable|mimes:jpeg,jpg,png',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return User::$messages;
    }
}
