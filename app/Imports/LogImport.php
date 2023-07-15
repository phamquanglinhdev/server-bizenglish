<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LogImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     * @return Model|array|Log|null
     */
    public function model(array $row): Model|array|Log|null
    {

        $data = [
            'grade_id' => Grade::query()->where("name", $row["classroom"])->first()->id,
            'date' => Carbon::parse(Date::excelToDateTimeObject($row['date']))->isoFormat("YYYY-MM-DD"),
            'start' => Carbon::parse(Date::excelToDateTimeObject($row['start']))->isoFormat("HH:mm"),
            'end' => Carbon::parse(Date::excelToDateTimeObject($row['end']))->isoFormat("HH:mm"),
            'duration' => $row["duration"],
            'lesson' => $row["lesson"],
            'hour_salary' => $row["hour_salary"],
            'log_salary' => $row["duration"] / 60 * $row["hour_salary"],
            'status' => '[{"name":"0","time":"","message":""}]',
            'teacher_id' => User::query()->where("code",$row["teacher_code"])->first()->id,
            'question' => $row["exercise"],
            'information' => $row["information"],
            'assessment' => $row["teacher_assessment"],
            'drive' => $row["drive_video"],
            'number_of_student' => $row["number_of_student"],
        ];
        return new Log($data);
    }
}
