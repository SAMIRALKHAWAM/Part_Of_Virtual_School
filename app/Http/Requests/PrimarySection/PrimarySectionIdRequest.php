<?php

namespace App\Http\Requests\PrimarySection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrimarySectionIdRequest extends FormRequest
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
            'primarySectionId' => [Rule::exists('primary_sections', 'id'), 'required', 'numeric'],
        ];
    }
}
