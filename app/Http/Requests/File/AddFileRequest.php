<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddFileRequest extends FormRequest
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
            'secondary_section_id' => [Rule::exists('secondary_sections', 'id'), 'required', 'numeric'],
            'url' => [function ($attribute, $value, $fail) {

                if (!\is_file($this->url)) {
                    $fail("url must be File type pdf");
                } elseif (\is_file($this->url) &&
                    strtolower($this->url->getClientOriginalExtension()) != "pdf"
                ) {
                    $fail("url must be File type pdf");
                }
            }],
        ];
    }
}
