<?php

namespace App\Jobs;

use App\Models\Grade;
use App\Models\User;
use GuzzleHttp\Client;
use http\Client\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ExpoNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Grade $grade;

    /**
     * Create a new job instance.
     */
    public function __construct(Grade $grade)
    {
        $this->grade = $grade;
    }

    public function send()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * @var User $student
         */
        $students = $this->grade->Students()->get();
        foreach ($students as $student) {
            $devices = $student->Device()?->get();
            foreach ($devices as $device) {
                $body = json_encode([
                    "to" => $device->token,
                    "title" => "Lớp học sắp bắt đầu",
                    "body" => $student->name . " ơi, lớp học " . $this->grade->name . " sắp bắt đầu, hãy chuẩn bị tham gia học nhé !",
                ]);
                try {
                    Http::withBody($body)->post('https://exp.host/--/api/v2/push/send');
                } catch (\Exception $exception) {

                }
            }
        }

    }
}
