<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;

class Customer extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'users';
    protected $guarded = ["id"];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'extra' => 'json',
    ];

    public function Contests(): BelongsToMany
    {
        return $this->belongsToMany(Contest::class, "customer_contest", "customer_id", "contest_id")
            ->withPivot(["score", "correct", "total", "correct_task"]);
    }
}
