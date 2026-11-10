<?php

namespace App\Http\Requests;

use App\Models\JobType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobTypeRequest extends FormRequest
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
        $jobType = $this->route('jobType');
        $rules = JobType::$rules;
        $rules['name'] = 'required|max:160|unique:job_types,name,'.$jobType->id;

        return $rules;
    }
}
