<?php

namespace App\Dtos\Log;

use Illuminate\Support\Str;

class LogListDto
{
    public function __construct(
        private readonly string $title,
        private readonly string $grade,
        private readonly string $time,
        private readonly string $note,
        private readonly int    $id,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'title' => Str::limit($this->title, 30),
            'time' => $this->time,
            'id' => $this->id,
            'note' => Str::limit($this->note),
            'grade' => $this->grade,
        ];
    }
}
