<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\SyncConversation;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/user", [UserController::class, "userAuth"]);
    Route::get("/current-grade", [UserController::class, "currentGradeInfo"]);
    Route::get("/student/grades", [GradeController::class, "getGradesForStudent"]);
    Route::get("/student/logs/{grade_id?}", [LogController::class, "getLogsForStudent"]);
    Route::get("/student/calendar", [UserController::class, "getStudentCalendar"]);
    Route::get("/student/log/{log_id}", [LogController::class, "getLogForStudent"]);
    Route::get("/student/grade/{grade_id}", [GradeController::class, "getGradeDetailForStudent"]);
    Route::get("/book/home", [BookController::class, 'BookForHome']);
    Route::get("/conversation/sync", [SyncConversation::class, "syncGrade"]);
    Route::get("/student/conversations", [ConversationController::class, "getConversationsForStudent"]);
    Route::get("/conversation/{socket_id}", [ConversationController::class, "getConversationBySocketId"]);
    Route::post("/chat/create", [ConversationController::class, "createChat"]);
    Route::post("/device", [DeviceController::class, "addToken"]);
    Route::get("/user/setting", [UserController::class, "getProfile"]);
    Route::post("/upload/image", [UploadController::class, "imageUpload"]);
    Route::post("/upload/video", [UploadController::class, "videoUpload"]);
});
Route::post("/login", [UserController::class, "login"]);


