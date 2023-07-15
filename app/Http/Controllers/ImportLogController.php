<?php

namespace App\Http\Controllers;

use App\Imports\LogImport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ImportLogController extends Controller
{
    public function importAction(): View
    {
        return view("import");
    }

    public function importLog(Request $request)
    {
        $important = Excel::import(new LogImport, $request->file("logs"));
    }
}
