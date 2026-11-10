<?php

namespace App\Http\Requests;

use App\Models\PostCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostCategoryRequest extends FormRequest
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
        $rules = PostCategory::$rules;
        $rules['name'] = 'required|max:180|unique:post_categories,name,'.$this->route('postCategory')->id;

        return $rules;
    }
}
