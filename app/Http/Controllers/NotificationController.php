<?php

namespace App\Http\Controllers;

use App\Dtos\Notification\NotificationListDto;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository
    )
    {
    }

    public function notification(): View
    {
        $notificationsCollection = $this->notificationRepository->getNotificationPaginate();
        $notificationListDto = new NotificationListDto(notifications: $notificationsCollection);
        return view("notification", ['notificationListDto' => $notificationListDto]);
    }
}
