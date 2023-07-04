<?php

namespace App\Dtos\Conversation;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class ConversationListDto
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
        $chat = $conversation->Chat()?->orderBy("created_at", "DESC")->with("user")->first() ?? null;
        $head = "Chưa có tin nhắn trong đoạn chat";
        if ($chat) {
            $head = $chat["user"]["name"] . " : " . $chat["text"];
        }
        return [
            'name' => $conversation["name"],
            'socket_id' => $conversation["socket_id"],
            'head' => $head
        ];
    }
}
