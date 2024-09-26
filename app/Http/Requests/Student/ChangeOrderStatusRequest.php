<?php

namespace App\Http\Requests\Student;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeOrderStatusRequest extends FormRequest
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
            'orderId' => [Rule::exists('user_secondary_sections', 'id')->where('status',OrderStatusEnum::Pending), 'required', 'numeric'],
            'status' => [Rule::in(OrderStatusEnum::toArray()), 'required'],
        ];
    }
}
