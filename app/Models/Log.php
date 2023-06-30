<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $table = "logs";

    public function Grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, "grade_id", "id");
    }

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, "teacher_id", "id");
    }
}
