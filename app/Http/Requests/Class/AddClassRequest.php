<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddClassRequest extends FormRequest
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
            'name' => [Rule::unique('u_classes'),'required'],
            'subjects' => 'required',
            'subjects.*' => [Rule::exists('subjects','id'),'required','numeric','distinct'],
        ];
    }
}
