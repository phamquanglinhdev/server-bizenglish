<?php

namespace App\Dtos\Conversation;

use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChatDto
{
    public function __construct(
        readonly private Model $chat
    )
    {
    }

    public function toArray(): array
    {
        /**
         * @var Chat $chat
         */
        $chat = $this->chat;
        return [
            'name' => $chat->User()->first()->name,
            'user' => $chat->User()->first()->email,
            'conversation_id' => $chat['conversation_id'],
            'type' => $chat["type"],
            'content' => $chat['text'],
            'time' => Carbon::parse($chat["created_at"])->isoFormat("DD-MM-YYYY H:m")
        ];
    }
}
