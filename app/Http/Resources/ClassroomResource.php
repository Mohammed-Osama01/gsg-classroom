<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->name,
            'code'=>$this->code,
            'meta'=>[
                'section' =>$this->section,
                'room' =>$this->room,
                'subject' =>$this->subject,
                'student_count' =>$this->students_count ?? 0,
            ],
            'user'=> [
                'name' =>$this->user->name
            ],
        ];
    }
}
