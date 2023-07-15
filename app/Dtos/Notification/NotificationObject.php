<?php

namespace App\Dtos\Notification;

class NotificationObject
{
    public function __construct(
        private readonly string $title,
        private readonly string $message,
        private readonly string $active,
        private readonly string $create,
        private readonly string $update,
    )
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getCreate(): string
    {
        return $this->create;
    }

    /**
     * @return string
     */
    public function getUpdate(): string
    {
        return $this->update;
    }
}
