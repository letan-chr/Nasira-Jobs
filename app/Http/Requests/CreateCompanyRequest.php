<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateCompanyRequest extends FormRequest
{
    /**
     * @throws ValidationException
     */
    public function prepareForValidation()
    {
        $employerDetails = trim(request()->get('details'));
        if (empty($employerDetails)) {
            throw ValidationException::withMessages([
                'details' => __('messages.employer_details_required'),
            ]);
        }
    }

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
        $rules = Company::$rules;
        $rules['name'] = 'required|max:180';
        $rules['email'] = 'required|email:filter|unique:users,email';
        $rules['password'] = 'required|same:password_confirmation|min:8';
        $rules['phone'] = 'nullable';
        $rules['image'] = 'required|mimes:jpg,jpeg,png';

        return $rules;
    }

//    /**
//     * @return array|string[]
//     */
//    public function messages()
//    {
//        return [
//            'country_id.required' => 'The country field is required.',
//            'website.url' => ''
//        ];
//    }
}
