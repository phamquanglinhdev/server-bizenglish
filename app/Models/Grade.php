<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Builder;

class Grade extends Model
{
    use HasFactory;

    protected $table = "grades";

    public function Students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "student_grade", "grade_id", "student_id");
    }

    public function Teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "teacher_grade", "grade_id", "teacher_id");
    }

    public function Logs(): HasMany|Builder|null
    {
        return $this->hasMany(Log::class, "grade_id", "id")->where("disable", 0);
    }

    public function Books(): BelongsToMany
    {
        return $this->belongsToMany(Bag::class, "grade_menus", "grade_id", "menu_id");
    }
}
