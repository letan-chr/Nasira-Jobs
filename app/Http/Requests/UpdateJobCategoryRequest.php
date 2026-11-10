<?php

namespace App\Http\Requests;

use App\Models\JobCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobCategoryRequest extends FormRequest
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
        $rules = JobCategory::$rules;
        $rules['name'] = 'required|max:160|unique:job_categories,name,'.$this->route('jobCategory')->id;
        $rules['customer_image'] = 'nullable|mimes:jpeg,jpg,png';

        return $rules;
    }

    public function messages(): array
    {
        $messages['customer_image.mimes'] = __('messages.image_type');

        return $messages;
    }
}
