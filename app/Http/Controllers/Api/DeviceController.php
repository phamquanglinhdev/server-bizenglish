<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function addToken(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $request->user();
        if (Device::query()->where("token", $request->token)->count() == 0) {
            Device::query()->create([
                'user_id' => $user["id"],
                'token' => $request->token,
                'platform' => $request->platform ?? "IOS"
            ]);
        }
    }
}
