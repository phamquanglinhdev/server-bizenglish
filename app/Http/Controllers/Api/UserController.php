<?php

namespace App\Http\Controllers\Api;

use App\Dtos\User\CurrentGradeUserDto;
use App\Dtos\User\UserAuthDtos;
use App\Dtos\User\UserCalendarDto;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Repositories\GradeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(
        readonly private UserRepository  $userRepository,
        readonly private GradeRepository $gradeRepository,
    )
    {
    }

    public function login(Request $request): array|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email' => 'Sai định dạng email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first()
            ], 401);
        }
        /**
         * @var User $user
         */
        $user = $this->userRepository->findByEmail($request["email"]);
        if ($user) {
            if (Hash::check($request['password'], $user['password'])) {
                return ["token" => "Bearer " . $user->createToken("Bearer")->plainTextToken];
            }
            return response()->json(['message' => 'Sai mật khẩu'], 401);
        }
        return response()->json(['message' => 'Không tồn tại tài khoản'], 401);
    }

    public function userAuth(Request $request): array
    {
        /**
         * @var  User $user
         */
        $user = $request->user();
        return (new UserAuthDtos(name: $user["name"], email: $user["email"], avatar: $user['avatar'] ?? "https://cdn-icons-png.flaticon.com/512/6596/6596121.png", type: $user["type"]))->toArray();
    }

    public function currentGradeInfo(Request $request): array
    {
        /**
         * @var  User $user
         * @var Grade $grade
         */
        $user = $request->user();
        $grade = $this->gradeRepository->getCurrentGradeByStudent($user["id"]);
        $lesson = $grade->Logs()->count();
        $remaining = $grade["minutes"] - $grade->Logs()->sum("duration");
        return (new CurrentGradeUserDto(
            name: $grade["name"], lesson: $lesson, remaining: $remaining, exercises: ""
        ))->toArray();
    }

    public function getStudentCalendar(Request $request): mixed
    {
        /**
         * @var User $student
         * @var Grade $grade
         */
        $times = [];
        $student = $request->user();
        $grades = $student->StudentGrade()->where("disable", 0)->where("status", 0)->get();
        foreach ($grades as $grade) {
            $time = json_decode($grade["time"]);
            foreach ($time as $item) {
                $times[] = (new UserCalendarDto(
                    grade: $grade["name"], time: $item->value, day: $item->day
                ))->toArray();
            }
        }
        return $times;
    }

}
