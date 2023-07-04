<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chats";
    protected $guarded = ["id"];

    public function Conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, "conversation_id", "id");
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
