<?php

namespace App\Repositories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ConversationRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return Conversation::class;
    }

    public function getConversationByStudentId($student_id): Collection|array
    {
        return $this->getBuilder()->whereHas("users", function (Builder $student) use ($student_id) {
            $student->where("id", $student_id);
        })->orderBy("updated_at", "DESC")->get();
    }

    public function hasConversation($name): bool
    {
        return $this->getBuilder()->where("name", $name)->count() > 0;
    }

    public function getConversationBySocketId($socket_id): Model|Builder|null
    {
        return $this->getBuilder()->where("socket_id", $socket_id)->first();
    }

    public function create(array $attributes, array $students = [], array $teachers = [])
    {
        $user = array_merge($students, $teachers);
        /**
         * @var Conversation $conversation
         */
        $conversation = $this->getBuilder()->create($attributes);
        $conversation->User()->sync($user);
    }
}
