<?php

namespace App\Repositories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GradeRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return Grade::class;
    }

    public function getGradesByStudent($student_id): Collection|array|null
    {
        return $this->getBuilder()->whereHas("Students", function (Builder $builder) use ($student_id) {
            $builder->where("id", $student_id);
        })->where("disable", 0)->orderBy("created_at", "DESC")->get();
    }

    public function getCurrentGradeByStudent($student_id): Model|Builder|null
    {
        return $this->getBuilder()
            ->whereHas("Students", function (Builder $builder) use ($student_id) {
                $builder->where("id", $student_id);
            })
            ->where("disable", 0)
            ->orderBy("created_at", "DESC")->first();
    }

    public function getGradeById($id): Model|Builder|null
    {
        return $this->getBuilder()->where("id", $id)->first();
    }

}
