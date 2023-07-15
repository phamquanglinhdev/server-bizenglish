@php
    use App\Dtos\Notification\NotificationListDto;
    /**
* @var NotificationListDto $notificationListDto
 */
    $notifications = $notificationListDto->getNotifications();
//    dd($notifications);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thông báo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Tiêu đề
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nội dung
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Trạng thái
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Thời gian tạo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Thời gian hoạt động
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notifications as $notification)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$notification->getTitle()}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$notification->getMessage()}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$notification->getActive()}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$notification->getCreate()}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$notification->getUpdate()}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-4 mt-4">
                        {{$notificationListDto->getLink()->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
