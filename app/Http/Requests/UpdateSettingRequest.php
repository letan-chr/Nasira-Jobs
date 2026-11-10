<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateSettingRequest extends FormRequest
{
    /**
     * @throws ValidationException
     */
    public function prepareForValidation()
    {
        $companyDescription = trim(request()->get('company_description'));
        $sectionName = request()->all();
        if ($sectionName['sectionName'] == 'general') {
            if (empty($companyDescription)) {
                throw ValidationException::withMessages([
                    'company_description' =>  __('messages.setting.company_description_required'),
                ]);
            }
            if (empty(request()->get('company_url'))) {
                throw ValidationException::withMessages([
                    'company_url' => __('messages.setting.company_url_required'),
                ]);
            }
        } else {
            if ($sectionName['sectionName'] == 'front_office_details') {
                if (empty(trim(request()->get('address')))) {
                    throw ValidationException::withMessages([
                        'address' => __('messages.setting.address_required'),
                    ]);
                }
                $validated = request()->validate([
                    'email' => 'required|email:filter|unique:users,email',
                ]);
            } else {
                if ($sectionName['sectionName'] == 'about_us') {
                    if (empty((request()->get('about_us')))) {
                        throw ValidationException::withMessages([
                            'company_description' => 'About Us is required',
                        ]);
                    }
                }
            }
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
        $rules = [
            'application_name' => 'required_with:company_description',
            'logo' => 'nullable|mimes:jpeg,jpg,png',
            'footer_logo' => 'nullable|mimes:jpeg,jpg,png',
            'favicon' => 'nullable|mimes:jpeg,jpg,png',
        ];

        if ($this->input('sectionName') == 'general') {
            $rules['default_language'] = 'required';
        }

        return $rules;
    }
}
