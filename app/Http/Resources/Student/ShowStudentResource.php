<?php

namespace App\Http\Resources\Student;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'payments' =>(float) $this->UserSecondarySections()->where('status',OrderStatusEnum::Accepted)->sum('price'),
        ];
    }
}
