<?php

namespace App\Dtos\User;

use Carbon\Carbon;

class UserCalendarDto
{
    public function __construct(
        private readonly string $grade,
        private readonly string $time,
        private readonly string $day,
    )
    {
    }

    public function dayTrans()
    {
        return [
            'mon' => 'Thứ hai',
            'tue' => 'Thứ ba',
            'wed' => 'Thứ tư',
            'thu' => 'Thứ năm',
            'fri' => 'Thứ sáu',
            'sat' => 'Thứ bảy',
            'sun' => 'Chủ nhật',
        ];
    }

    public function getDayOfWeekDay()
    {
        return Carbon::parse($this->day)->isoFormat("DD/MM/YYYY");
    }

    public function remainingDay()
    {
        $day = Carbon::parse($this->day);
        $rm = Carbon::parse($day)->diffInDays() + 1;
        if ($rm == 0) {
            return "Hôm nay";
        }
        return $rm . " ngày";
    }

    public function getStart(): string
    {
        $tmp = explode("-", $this->time)[0];
        if (str_contains($this->time, "pm")) {
            $tmp = $tmp . "PM";
        }
        return Carbon::parse($tmp)->toTimeString();
    }

    public function toArray(): array
    {
        return [
            'grade' => $this->grade,
            'start' => $this->getStart(),
            'time' => $this->time,
            'day' => $this->dayTrans()[$this->day],
            'this_week' => $this->getDayOfWeekDay(),
            'rm_day' => $this->remainingDay(),
            'raw' => Carbon::parse($this->day) . " " . $this->getStart()
        ];
    }
}
