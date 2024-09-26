<?php

namespace App\Http\Resources\Class;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowClassSubjectsResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'subject_name' => $this->Subject->name,
        ];
    }
}
