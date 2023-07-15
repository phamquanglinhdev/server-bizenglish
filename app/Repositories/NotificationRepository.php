<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NotificationRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return Notification::class;
    }

    public function getNotificationPaginate(): LengthAwarePaginator
    {
        return $this->getBuilder()->paginate(10);
    }
}
