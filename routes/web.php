<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {return view('Admin.index');});
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/gym_manager', function () {return view('GymManager.index');});
    Route::get('/city_manager', function () {return view('CityManager.index');});
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {return view('auth.login');});
