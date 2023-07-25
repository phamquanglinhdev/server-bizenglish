<?php

namespace App\Http\Controllers\Api;

use App\Dtos\Grade\GradeDetailDto;
use App\Dtos\Grade\GradeListDto;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Repositories\GradeRepository;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct(
        private readonly GradeRepository $gradeRepository
    )
    {
    }

    public function getGradesForStudent(Request $request): array
    {
        $status = [
            0 => 'Đang học',
            1 => 'Đã kết thúc',
            2 => 'Đã bảo lưu'
        ];
        /**
         * @var User $student
         */
        $student = $request->user();
        $grades = $this->gradeRepository->getGradesByStudent($student["id"]);
        return $grades->map(fn(Grade $grade) => (new GradeListDto(
            id: $grade["id"],
            name: $grade["name"],
            status: $status[$grade["status"]], teacher_name: $grade->Teachers()->first()->name,
            learn_minutes: $grade->Logs()->sum("duration"),
            remaining: $grade["minutes"] - $grade->Logs()->sum("duration"),
            days: ["T2", "T3"]
        ))->toArray())->toArray();
    }

    public function getGradeDetailForStudent(Request $request, $grade_id): array
    {
        /**
         * @var User $student
         * @var Grade $grade
         */
        $student = $request->user();
        $grade = $this->gradeRepository->getGradeById($grade_id);
        if (!$grade) {
            return [];
        }
        return (new GradeDetailDto(grade: $grade))->toArray();

    }

}
