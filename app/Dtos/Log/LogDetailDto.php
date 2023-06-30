<?php

namespace App\Dtos\Log;

class LogDetailDto
{
    public function __construct(
        private readonly ?string $video,
        private readonly string $title,
        private readonly string $time,
        private readonly string $grade,
        private readonly string $teacher,
        private readonly array $student,
        private readonly string $salary,
        private readonly string $note,
        private readonly string $exercise,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'video' => $this->video,
            'time' => $this->time,
            'grade' => $this->grade,
            'teacher' => $this->teacher,
            'title' => $this->title,
            'student' => $this->student,
            'salary' => $this->salary,
            'note' => $this->note,
            'exercise' => $this->exercise
        ];
    }
}
