<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddQuestionRequest extends FormRequest
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
            'exam_section_id' => [Rule::exists('exam_sections', 'id'), 'required', 'numeric'],
            'question_type_id' => [Rule::exists('question_types', 'id'), 'required', 'numeric'],
            'question' => 'required',
            'file' => 'nullable|file',
            'mark' => 'numeric|required',
        ];
    }
}
