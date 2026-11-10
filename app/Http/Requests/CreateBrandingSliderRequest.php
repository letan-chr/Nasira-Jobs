<?php

namespace App\Http\Requests;

use App\Models\BrandingSliders;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateBrandingSliderRequest
 */
class CreateBrandingSliderRequest extends FormRequest
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
        return BrandingSliders::$rules;
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'branding_slider.required' => __('messages.image_required'),
        ];
    }
}
