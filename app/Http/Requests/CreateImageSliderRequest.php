<?php

namespace App\Http\Requests;

use App\Models\ImageSlider;
use Illuminate\Foundation\Http\FormRequest;

class CreateImageSliderRequest extends FormRequest
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
        return ImageSlider::$rules;
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'image_slider.required' => __('messages.image_required'),
        ];
    }
}
