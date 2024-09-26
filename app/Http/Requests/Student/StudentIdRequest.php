<?php

namespace App\Http\Requests\Student;

use App\Enums\ActorTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentIdRequest extends FormRequest
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
        $type = \returnActorType();
        if ($type === 'Admin') {
            return [
                'studentId' => [Rule::exists('actors', 'id')->where('type', ActorTypeEnum::Student), 'required', 'numeric'],
            ];
        } else {
            return [
                'studentId' => [Rule::exists('actors', 'id')->where('type', ActorTypeEnum::Student)
                    ->where('id', \auth('actor')->user()->id), 'required', 'numeric'],
            ];
        }
    }
}
