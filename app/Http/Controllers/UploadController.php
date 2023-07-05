<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function imageUpload(Request $request): string
    {
        $img = $request->file("img");
        $upload = Storage::disk("application")->put("/user/avatar/", $img);
        return url("/uploads/application/" . $upload);
    }
}
