<?php

namespace App\Http\Requests;

use App\Models\JobCategory;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobCategoryRequest extends FormRequest
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
        return JobCategory::$rules;
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return  [
            'customer_image.mimes' => __('messages.image_type'),
        ];
    }
}
