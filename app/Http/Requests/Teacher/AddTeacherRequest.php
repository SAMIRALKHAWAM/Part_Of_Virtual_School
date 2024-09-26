<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddTeacherRequest extends FormRequest
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
            'name' => 'required',
            'email' => [Rule::unique('actors'), 'required', 'email'],
            'password' => 'required|min:8|confirmed',
            'phone' => 'numeric|required',
            'subjects' => 'required',
            'subjects.*' => [Rule::exists('subjects', 'id'), 'required', 'numeric', 'distinct'],
            'classes' => 'required',
            'classes.*' => [Rule::exists('u_classes', 'id'), 'required', 'numeric', 'distinct'],
        ];
    }
}
