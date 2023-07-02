<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BookRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return Book::class;
    }


    public function getTrendingBooks(string $limit = null): Collection|array
    {
        return $this->getBuilder()->orderBy("created_at", "ASC")->limit($limit)->get();
    }

    public function getRecommendBook(string $limit = null): Collection|array
    {
        return $this->getBuilder()->orderBy("created_at", "DESC")->limit($limit)->get();
    }

    public function getByStudent($studentId, $limit = null): Collection|array
    {
        return $this->getBuilder()->whereHas("bag", function (Builder $bag) use ($studentId) {
            $bag->whereHas("grades", function (Builder $grade) use ($studentId) {
                $grade->whereHas("students", function (Builder $student) use ($studentId) {
                    $student->where("id", $studentId);
                });
            });
        })->limit($limit)->get();
    }

}
