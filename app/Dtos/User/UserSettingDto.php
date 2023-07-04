<?php

namespace App\Dtos\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserSettingDto
{
    public function __construct(
        private readonly Model|Builder $user
    )
    {
    }

    public function toArray(): array
    {
        /**
         * @var User $student
         */
        $student = $this->user;
        return [
            'name' => $student['name'],
            'avatar' => $student["avatar"],
            'code' => $student["code"],
            'phone' => $student['phone'],
            'email' => $student['email'],
            'parent' => $student['parent_name']
        ];
    }
}
