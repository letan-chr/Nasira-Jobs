<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
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
            'customer_name' => 'required',
            'customer_image' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'customer_image.required' => __('messages.image_required'),
        ];
    }
}
