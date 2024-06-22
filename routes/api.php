<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\VideosController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CallUsController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\NotificationsController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
    Route::post('send-code', 'sendCode');
});
Route::post('call-us', [CallUsController::class, 'store']);
Route::get('setting', SettingController::class);

Route::post('courses', [CoursesController::class, 'index']);
Route::get('courses/{id}', [CoursesController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('activateAccount', [AuthController::class, 'activateAccount']);
    Route::post('resendActivation', [AuthController::class, 'resendActivation']);
        Route::get('profile', [UsersController::class, 'show']);
    Route::post('update-profile', [UsersController::class, 'update']);

    Route::post('video/{id}', [VideosController::class, 'show']);

    Route::get('notifications', NotificationsController::class);


});
Route::get('notifications/send', [UsersController::class,'send']);
Route::get('video/info/{url}', [VideosController::class,'getVideoInfo']);
