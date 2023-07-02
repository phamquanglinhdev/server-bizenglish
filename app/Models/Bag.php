<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bag extends Model
{
    use HasFactory;

    protected $table = "menus";
    protected $guarded = ['id'];

    public function Books(): HasMany
    {
        return $this->hasMany(Book::class, "menu_id", "id");
    }

    public function Grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, "grade_menus", "menu_id", "grade_id");
    }
}
