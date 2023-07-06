<?php

namespace App\Dtos\Log;

use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LogDetailDto
{
    public function __construct(
        private readonly Model|Builder $log,
        private readonly mixed  $acp
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
        if ($this->acp) {
            $acp = $this->acp->accept == 1 ? "Xác nhận đúng thông tin" : "Xác nhận chưa đúng thông tin( " . $this->acp->comment . " )";
        } else {
            $acp = "Chưa xác nhận";
        }
        return [
            'video' => $video ?? null,
            'lesson' => $log["lesson"],
            'date' => Carbon::parse($log["date"])->isoFormat("DD/MM/YYYY"),
            'time' => $log["start"] . "-" . $log["end"],
            'duration' => $log['duration'],
            'grade' => $log->Grade()->first()->name,
            "teacher" => $log->Teacher()->first()->name,
            "note" => $log["assessment"] ?? "-",
            "information" => $log['information'],
            "exercise" => $log["question"] ?? "-",
            'attachments' => json_decode($log['attachments']),
            'confirm' => $acp

        ];
    }
}
