<?php

namespace App\Dtos\Grade;

class GradeListDto
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $status,
        private readonly string $teacher_name,
        private readonly int    $learn_minutes,
        private readonly int    $remaining,
        private readonly array  $days
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'status'=>$this->status,
            'teacher'=>$this->teacher_name,
            'learn'=>$this->learn_minutes,
            'remaining'=>$this->remaining,
            'days'=>$this->days
        ];
    }
}
