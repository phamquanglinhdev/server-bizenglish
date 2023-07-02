<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = "books";
    protected $guarded = ["id"];

    public function Bag(): BelongsTo
    {
        return $this->belongsTo(Bag::class, "menu_id", "id");
    }
}
