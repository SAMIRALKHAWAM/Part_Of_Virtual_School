<?php

namespace App\Http\Requests\SecondarySection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditSecondarySectionRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'secondarySectionId' => [Rule::exists('secondary_sections', 'id'), 'required', 'numeric'],
            'name' => 'required',
            'price' => 'required|numeric',

        ];
    }
}
