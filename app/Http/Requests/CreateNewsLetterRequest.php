<?php

namespace App\Http\Requests;

use App\Models\NewsLetter;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateNewsLetterRequest
 */
class CreateNewsLetterRequest extends FormRequest
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
        return NewsLetter::$rules;
    }

    public function messages(): array
    {
        return [
            // 'email.unique' => 'You are already subscribed.',
        ];
    }
}
