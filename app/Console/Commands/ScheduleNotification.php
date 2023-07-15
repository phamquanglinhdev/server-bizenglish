<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\UserController;
use App\Jobs\ExpoNotification;
use App\Models\Grade;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ScheduleNotification extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $grades = Grade::query()->where("disable", 0)->where("status", 0)->get();
        foreach ($grades as $grade) {
            $times = json_decode($grade->time);
            foreach ($times as $time) {
                $day = $time->day;
                try {
                    if ($time->start != "") {
                        $time = $time->start;
                        $schedule = Carbon::parse($day . " " . $time)->diffInMinutes();
                        if ($schedule < 1) {
                            ExpoNotification::dispatch(Grade::query()->find(1022));
                        }
                    }
                } catch (\Exception $exception) {

                }
//                dd($time->day.":".$day);
            }
        }
        $this->line("Bắt đầu kiểm tra");
    }
}
