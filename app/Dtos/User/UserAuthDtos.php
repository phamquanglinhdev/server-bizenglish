<?php

namespace App\Dtos\User;

/**
 *
 */
class UserAuthDtos
{
    /**
     * @param string $name
     * @param string $email
     * @param string $avatar
     * @param int $type
     */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $avatar,
        private readonly int    $type,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'type' => $this->type
        ];
    }
}
