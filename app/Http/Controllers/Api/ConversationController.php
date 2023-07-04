<?php

namespace App\Http\Controllers\Api;

use App\Dtos\Conversation\ChatDto;
use App\Dtos\Conversation\ConversationDto;
use App\Dtos\Conversation\ConversationListDto;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Conversation;
use App\Models\User;
use App\Repositories\ConversationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository
    )
    {
    }

    public function getConversationsForStudent(Request $request): mixed
    {
        /**
         * @var User $student
         */
        $student = $request->user();
        $conversations = $this->conversationRepository->getConversationByStudentId($student["id"]);
        return $conversations->map(fn(Conversation $conversation) => (new ConversationListDto(conversation: $conversation))->toArray())->toArray();
    }

    public function getConversationBySocketId(Request $request, $socketId): array
    {
        /**
         * @var Conversation $conversation
         */
        $conversation = $this->conversationRepository->getConversationBySocketId($socketId);
        return (new ConversationDto(conversation: $conversation))->toArray();
    }

    public function createChat(Request $request)
    {
        $conversation = $this->conversationRepository->getConversationBySocketId($request->socket_id);
        $user = $request->user();
        $data = [
            'conversation_id' => $conversation["id"],
            'user_id' => $user["id"],
            'type' => $request->type ?? "text",
            'text' => $request->{"content"} ?? "[=LIKE=]"
        ];
        $chat = Chat::query()->create($data);
        return (new ChatDto(chat: $chat))->toArray();
    }
}
