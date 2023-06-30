<?php

namespace App\Dtos\User;

class CurrentGradeUserDto
{
    public function __construct(
        private readonly string $name,
        private readonly int    $lesson,
        private readonly int    $remaining,
        private readonly string $exercises,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'lesson' => $this->lesson,
            'remaining' => $this->remaining,
            'exercise' => $this->exercises,
        ];
    }
}
