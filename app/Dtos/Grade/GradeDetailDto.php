<?php

namespace App\Dtos\Grade;

use App\Models\Grade;
use Carbon\Carbon;

class GradeDetailDto
{
    public function __construct(
        private readonly Grade $grade
    )
    {
    }

    public function toArray(): array
    {
        $status = [
            0 => 'Đang học',
            1 => 'Đã kết thúc',
            2 => 'Đã bảo lưu'
        ];
        return [
            'name' => $this->grade["name"],
            'teacher' => $this->grade->Teachers()->get(["name"]),
            'link' => $this->grade["zoom"],
            'student' => $this->grade->Students()->get(["name"]),
            'minutes' => $this->grade["minutes"],
            'remaining' => $this->grade["minutes"] - ($this->grade->Logs()->sum("duration")),
            'information' => $this->grade["information"] ?? "Lớp hiện không có thông tin chi tiết",
            'pricing' => number_format($this->grade["pricing"]),
            'attachment' => $this->grade["attachment"],
            'status' => $status[$this->grade['status']],
            'create_at' => Carbon::parse($this->grade['created_at'])->isoFormat("DD-MM-YYYY"),
            'logs' => $this->grade->Logs()->orderBy("created_at", "DESC")->get(["id", "lesson", "date"]),
            'books' => [
                [
                    "name" => "Sách mẫu",
                    "link" => 'https://fb.me',
                    "thumbnail" => 'https://sachtienganhhanoi.com/wp-content/uploads/2018/09/9780194432597.jpg'
                ],
                [
                    "name" => "Sách mẫu 2",
                    "link" => 'https://fb.me',
                    "thumbnail" => 'https://sachtienganhhanoi.com/wp-content/uploads/2018/09/9780194432597.jpg'
                ],
                [
                    "name" => "Sách mẫu 3",
                    "link" => 'https://fb.me',
                    "thumbnail" => 'https://sachtienganhhanoi.com/wp-content/uploads/2018/09/9780194432597.jpg'
                ],

            ]
        ];
    }
}
