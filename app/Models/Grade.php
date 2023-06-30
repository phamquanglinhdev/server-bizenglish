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

    public function Students(): BelongsToMany|Builder|null
    {
        return $this->belongsToMany(User::class, "student_grade", "grade_id", "student_id")->where("type", 3);
    }

    public function Logs(): HasMany|Builder|null
    {
        return $this->hasMany(Log::class, "grade_id", "id")->where("disable", 0);
    }
}
