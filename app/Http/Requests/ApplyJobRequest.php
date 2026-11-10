<?php

namespace App\Http\Requests;

use App\Models\JobApplication;
use App\Rules\ValidGoogleRecaptcha;
use App\Support\GoogleRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApplyJobRequest
 */
class ApplyJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $expectedSalary = removeCommaFromNumbers($this->request->get('expected_salary'));

        $this->request->set('expected_salary', $expectedSalary);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $candidateId = auth()->user()->owner_id ?? null;

        $rules = [
            'job_id' => 'required',
            'resume_id' => [
                'required',
                function ($attribute, $value, $fail) use ($candidateId) {
                    $ownsResume = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('id', $value)
                        ->where('model_type', \App\Models\Candidate::class)
                        ->where('model_id', $candidateId)
                        ->exists();
                    if (! $ownsResume) {
                        $fail(__('messages.flash.resume_field_required'));
                    }
                },
            ],
            'expected_salary' => 'required|numeric|min:0|max:9999999999',
        ];

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
            'resume_id.required' => __('messages.flash.resume_field_required'),
            'g-recaptcha-response.required' => __('messages.flash.verify_google_recaptcha'),
        ];
    }
}
