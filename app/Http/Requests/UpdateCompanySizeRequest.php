<?php

namespace App\Http\Requests;

use App\Models\CompanySize;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanySizeRequest extends FormRequest
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
        $companySize = $this->route('companySize');
        $rules = CompanySize::$rules;
        $rules['size'] = 'required|unique:company_sizes,size,'.$companySize->id;

        return $rules;
    }
}
