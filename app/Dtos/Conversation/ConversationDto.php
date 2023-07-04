<?php

namespace App\Dtos\Conversation;

use App\Models\Chat;
use App\Models\Conversation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class ConversationDto
{
    public function __construct(
        private readonly Model|Builder $conversation
    )
    {
    }

    public function toArray(): array
    {
        /**
         * @var Conversation $conversation
         */
        $conversation = $this->conversation;
        return [
            'conversation' => [
                'name' => $conversation["name"],
                'socket_id' => $conversation['socket_id']
            ],
            'chats' => array_reverse($conversation->Chat()->orderBy("created_at", "DESC")->take(30)->get()->map(
                function (Chat $chat) {
                    return [
                        'name' => $chat->User()->first()->name,
                        'user' => $chat->User()->first()->email,
                        'conversation_id' => $this->conversation["id"],
                        'type' => $chat["type"],
                        'content' => $chat['text'],
                        'time' => Carbon::parse($chat["created_at"])->isoFormat("DD-MM-YYYY H:m")
                    ];
                }
            )->toArray())
        ];
    }
}
