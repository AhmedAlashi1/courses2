<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\CoursesController;
use App\Http\Controllers\Dashboard\VideosController;
use App\Http\Controllers\Dashboard\SectionsController;
use App\Http\Controllers\Dashboard\BuyCourseUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class,'index'])->middleware('auth');
Route::post('send', [NotifyController::class, 'sendNotification'])->name('Notification.send');
Route::group([
    'prefix' => '/admin/',
    'middleware' => ['web']
], function () {

    Route::middleware('guest')->group(function () {
        Route::get('login',  [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('Admin.login');
    });
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class,'index'])->name('home');
        Route::resource('admins',AdminController::class);


        Route::resource('users',UserController::class);
        Route::get('/buy_course_user/{id}', [BuyCourseUserController::class, 'index'])->name('buy_course_user.index');
        Route::get('/buy_course_user/create/{id}', [BuyCourseUserController::class, 'create'])->name('buy_course_user.create');
        Route::post('/buy_course_user/store', [BuyCourseUserController::class, 'store'])->name('buy_course_user.store');
        Route::delete('/buy_course_user/{id}', [BuyCourseUserController::class, 'destroy'])->name('buy_course_user.destroy');
        Route::get('/buy_course_user/update-status/{id}', [BuyCourseUserController::class, 'updateStatus'])->name('update-buy_course_user-status');



        Route::post('/logout', [AuthController::class,'logout'])->name('Admin.logout');
        Route::get('/account-settings', [AuthController::class,'accountSettings'])->name('Admin.accountSettings');
        Route::post('/account-settings', [AuthController::class,'updateAccountSettings'])->name('Admin.updateAccountSettings');

        Route::resource('/roles', RoleController::class);

        //courses
        Route::resource('courses',CoursesController::class);
        Route::get('/courses/update-status/{id}', [CoursesController::class, 'updateStatus'])->name('update-courses-status');
        Route::get('excel', [CoursesController::class, 'FastExcel']);


        Route::get('/section/{courses_id}', [SectionsController::class, 'index'])->name('section.index');
        Route::get('/section/create/{courses_id}', [SectionsController::class, 'create'])->name('section.create');
        Route::post('/section/store', [SectionsController::class, 'store'])->name('section.store');
        Route::get('/section/edit/{id}', [SectionsController::class, 'edit'])->name('section.edit');
        Route::put('/section/update/{id}', [SectionsController::class, 'update'])->name('section.update');

        Route::delete('/section/{id}', [SectionsController::class, 'destroy'])->name('section.destroy');
        Route::get('/section/update-status/{id}', [SectionsController::class, 'updateStatus'])->name('update-section-status');


        //videos


                Route::group(['prefix' => 'videos'],function (){
            Route::get('show-all/{course_id}/{section_id}',[VideosController::class, 'index'])->name('videos.index');
            Route::get('/create/{course_id}/{section_id}',[VideosController::class, 'create'])->name('videos.create');
            Route::post('/store',[VideosController::class, 'store'])->name('videos.store');
            Route::get('/edit/{id}',[VideosController::class, 'edit'])->name('videos.edit');
            Route::post('/update/{id}',[VideosController::class, 'update'])->name('videos.update');
            Route::get('/delete/{id}',[VideosController::class, 'destroy'])->name('videos.delete');
        });
        // settings
        Route::get('settings/',[SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
    });

});

