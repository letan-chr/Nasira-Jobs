<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
        $jobTag = $this->route('tag');
        $rules = Tag::$rules;
        $rules['name'] = 'required|max:160|unique:tags,name,'.$jobTag->id;

        return $rules;
    }
}
