<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $table = "conversations";
    protected $guarded = ["id"];

    public function Chat(): HasMany
    {
        return $this->hasMany(Chat::class, "conversation_id", "id");
    }

    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "conversation_user", "conversation_id", "user_id");
    }

}
