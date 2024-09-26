<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowBillsResource extends JsonResource
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
            'secondary_section_id' => $this->secondary_section_id,
            'secondary_section_name' => $this->SecondarySection->name,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}
