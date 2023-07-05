<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\u;

class UploadController extends Controller
{
    public function imageUpload(Request $request): string
    {
        $img = $request->file("img");
        $upload = Storage::disk("application")->put("/image/", $img);
        return url("/uploads/application/" . $upload);
    }

    public function mediaUpload(Request $request): string
    {
        $video = $request->file("media");
        $upload = Storage::disk("application")->put("/media/", $video);
        return url("/uploads/application/" . $upload);
    }
}
