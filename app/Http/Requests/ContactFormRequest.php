<?php

namespace App\Http\Requests;

use App\Models\Inquiry;
use App\Rules\ValidGoogleRecaptcha;
use App\Support\GoogleRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
        $rules = Inquiry::$rules;
        if (GoogleRecaptcha::isEnabled()) {
            $rules['g-recaptcha-response'] = ['required', new ValidGoogleRecaptcha];
        }

        return $rules;
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => __('messages.verify_captcha'),
        ];
    }
}
