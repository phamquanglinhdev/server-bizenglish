<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;

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
                'time' => $log['date'] . " " . $log['start'] . " - " . $log["end"],
                'grade' => $log->Grade()->first()->name
            ];
        })->toArray();
    }
}
