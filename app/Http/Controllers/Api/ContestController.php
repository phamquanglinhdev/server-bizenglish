<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function getContest(Request $request): JsonResponse|array
    {
        /**
         * @var  Contest $contest
         */
        $contest_id = $request["contest_id"];
        $id = $request->user()->id;
        $contest = Contest::query()->whereHas("customers", function (Builder $customer) use ($id) {
            $customer->where("users.id", $id);
        })->where("id", $contest_id)->first();
        if (!$contest) {
            return response()->json(['message' => 'Không tìm thấy bài Test'], 404);
        }
        $pivot = $contest->Customers()->wherePivot("customer_id", $id)->first();
        if ($pivot["pivot"]['score'] != null) {
            return response()->json(['message' => 'Bạn đã làm bài Test này '], 401);
        }
        return [
            'name' => $pivot["name"],
            'title' => $contest['title'],
            'limit' => $contest['limit_time'],
            'body' => $contest['body']
        ];

    }

    public function play($contest_id, $user_id)
    {
        /**
         * @var Contest $contest
         */
        $contest = Contest::query()->whereHas("customers", function (Builder $customer) use ($user_id) {
            $customer->where("users.id", $user_id);
        })->where("id", $contest_id)->first();
        if (!$contest) {
            return response()->json(['message' => 'Không tìm thấy bài Test'], 404);
        }
        $pivot = $contest->Customers()->wherePivot("customer_id", $user_id)->first();
        if ($pivot["pivot"]['score'] != null) {
            return response()->json(['message' => 'Bạn đã làm bài Test này '], 401);
        }
        $user = Customer::query()->where("id", $user_id)->first();
        $token = "Bearer " . $user->createToken("Bearer")->plainTextToken;
        return redirect("http://localhost:3000?token=" . $token . "&contest=" . $contest_id);
    }
}
