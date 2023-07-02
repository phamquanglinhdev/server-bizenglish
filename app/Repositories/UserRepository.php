<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return User::class;
    }

    public function findByEmail(string $email): Model|Builder|null
    {
        return $this->getBuilder()->where("email", $email)->first();
    }

}
