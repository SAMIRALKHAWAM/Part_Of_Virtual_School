<?php

namespace App\Http\Resources\SubjectSection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowSubjectSectionsResource extends JsonResource
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
            'teacher_name' => $this->UserSubject->Actor->name,
            'class_name' => $this->UserClass->Class->name,
            'Subject_name' => $this->UserSubject->Subject->name,
        ];
    }
}
