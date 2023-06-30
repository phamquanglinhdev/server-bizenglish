<?php

namespace App\Http\Controllers\Api;

use App\Dtos\Log\LogDetailDto;
use App\Dtos\Log\LogListDto;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Repositories\LogRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LogController extends Controller
{
    public function __construct(
        private readonly LogRepository $logRepository
    )
    {
    }

    public function getLogsForStudent(Request $request, $gradeId = null): array
    {
        /**
         * @var User $student
         */
        $student = $request->user();
        $logs = $this->logRepository->getLogsByForStudent(studentId: $student["id"], gradeId: $gradeId);
        return $logs->map(fn(Log $log) => (new LogListDto(
            title: $log["lesson"],
            grade: $log->Grade()->first()->name,
            time: Carbon::parse($log["date"])->isoFormat("DD/MM/YYYY") . " " . $log["start"] . " - " . $log["end"],
            note: $log["assessment"] ?? "Không có ghi chú",
            id: $log["id"]
        ))->toArray()
        )->toArray();
    }

    public function getLogForStudent(Request $request, $log_id): mixed
    {
        /**
         * @var User $student
         * @var Log $log
         */
        $student = $request->user();
        $log = $student->StudentGrade()->whereHas("logs", function (Builder $log) use ($log_id) {
            $log->where("id", $log_id);
        })->first()?->Logs()->where("id", $log_id)->first();
        if (!$log) {
            return response()->json([], 404);
        }
        if ($log["teacher_video"]) {
            $video = json_decode($log["teacher_video"]);
            $video = "https://youtube.com/embed/$video->id";
        }
        return (new LogDetailDto(
            video: $video ?? null,
            title: $log["lesson"],
            time: $log["date"] . $log["start"] . $log["end"],
            grade: $log->Grade()->first()->name,
            teacher: $log->Teacher()->first()->name,
            student: $log->Grade()->first()->Students()->get(["id", "name"])->toArray(),
            salary: number_format($log["hour_salary"]),
            note: $log["assessment"] ?? "-",
            exercise: $log["question"] ?? "-"
        ))->toArray();
    }
}
