<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Repositories\ConversationRepository;
use App\Repositories\GradeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SyncConversation extends Controller
{
    public function __construct(
        private readonly GradeRepository        $gradeRepository,
        private readonly ConversationRepository $conversationRepository,

    )
    {
    }

    public function syncGrade(Request $request): JsonResponse
    {

        /**
         * @var Grade $grade
         * @var User $student
         */
        $student = $request->user();
        $grades = $this->gradeRepository->getGradesByStudent($student["id"]);
        foreach ($grades as $grade) {
            if (!$this->conversationRepository->hasConversation("Lớp " . $grade["name"])) {
                $this->conversationRepository->create([
                    "name" => 'Lớp ' . $grade["name"],
                    "type" => 1,
                    'socket_id' => Str::random(10)
                ], $grade->Students()->allRelatedIds()->toArray(), $grade->Teachers()->allRelatedIds()->toArray());
            }
        }
        return response()->json([], 200);
    }
}
