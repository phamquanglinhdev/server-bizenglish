<?php

namespace App\Dtos\Log;

use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LogDetailDto
{
    public function __construct(
        private readonly Model|Builder $log
    )
    {
    }

    public function toArray(): array
    {

        /**
         * @var Log $log
         */
        $log = $this->log;
        if ($log["teacher_video"]) {
            $video = json_decode($log["teacher_video"]);
            $video = "https://youtube.com/embed/$video->id";
        }
        return [
            'video' => $video ?? null,
            'lesson' => $log["lesson"],
            'date' => $log["date"],
            'time' => $log["start"] . "-" . $log["end"],
            'duration' => $log['duration'],
            'grade' => $log->Teacher()->first()->name,
            "teacher" => $log->Teacher()->first()->name,
            "note" => $log["assessment"] ?? "-",
            "information" => $log['information'],
            "exercise" => $log["question"] ?? "-",
            'attachments' => $log['attachments'],
        ];
    }
}
