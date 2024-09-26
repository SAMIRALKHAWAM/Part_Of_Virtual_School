<?php

namespace App\Http\Requests\Teacher;

use App\Enums\ActorTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditTeacherClassesRequest extends FormRequest
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
            'teacherId' => [Rule::exists('actors', 'id')->where('type', ActorTypeEnum::Teacher), 'required', 'numeric'],
            'classes' => 'required',
            'classes.*' => [Rule::exists('u_classes', 'id'), 'required', 'numeric', 'distinct'],
        ];
    }
}