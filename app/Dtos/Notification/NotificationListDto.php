<?php

namespace App\Dtos\Notification;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NotificationListDto
{
    public function __construct(
        private readonly LengthAwarePaginator $notifications
    )
    {
    }

    /**
     * @return NotificationObject[]
     */
    public function getNotifications(): array
    {
        return $this->notifications->map(fn(Notification $notification) => new NotificationObject(
            title: $notification['title'],
            message: $notification['message'],
            active: $notification['read'] == 0 ? "Chưa gửi" : "Đã gửi",
            create: Carbon::parse($notification["created_at"])->isoFormat("DD/MM/YYYY HH:mm:ss"),
            update: Carbon::parse($notification["updated_at"])->isoFormat("DD/MM/YYYY HH:mm:ss"),
        ))->toArray();
    }

    public function getLink(): LengthAwarePaginator
    {
        return $this->notifications;
    }

}
