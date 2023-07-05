<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Log;
use App\Models\User;
use App\Repositories\LogRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExerciseController extends Controller
{
    public function __construct(
        private readonly LogRepository $logRepository
    )
    {
    }

    public function getLog(Request $request): array
    {
        /**
         * @var User $student
         */
        $student = $request->user();
        $logs = $this->logRepository->getLogsByForStudent($student["id"]);
        return $logs->map(function (Log $log) {
            return [
                'id' => $log['id'],
                'lesson' => $log["lesson"],
                'time' => Carbon::parse($log['date'])->isoFormat("DD/MM") . " " . $log['start'] . " - " . $log["end"],
                'grade' => $log->Grade()->first()->name,
                'question' => $log["question"]
            ];
        })->toArray();
    }

    public function createExercise(Request $request): Model|Builder
    {
        /**
         * @var User $student
         */
        $student = $request->user();
        $dataCreate = [
            'student_id' => $student["id"],
            "log_id" => $request["log_id"],
            "video" => $request["video"],
            "paragraph" => $request["paragraph"],
            "document" => $request["document"]
        ];
        return Exercise::query()->create($dataCreate);
    }
}
