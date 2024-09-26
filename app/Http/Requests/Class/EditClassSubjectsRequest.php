<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditClassSubjectsRequest extends FormRequest
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
            'classId' => [Rule::exists('u_classes', 'id'), 'required', 'numeric'],
            'subjects' => 'required',
            'subjects.*' => [Rule::exists('subjects','id'),'required','numeric','distinct'],
        ];
    }
}
