<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LogRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return Log::class;
    }

    public function getLogsByForStudent($studentId, $gradeId = null): Collection|array
    {
        if ($gradeId) {
            return $this->getBuilder()->where("grade_id", $gradeId)->where("disable", 0)->get();
        }
        return $this->getBuilder()->whereHas("grade", function (Builder $grade) use ($studentId) {
            $grade->whereHas("students", function (Builder $student) use ($studentId) {
                $student->where("id", $studentId);
            });
        })->where("disable", 0)->orderBy("date", "DESC")->get();
    }
}
