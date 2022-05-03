<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TraineeController; 

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
    Route::get('/gym_manager', function () {return view('GymManager.index');});
    Route::get('/city_manager', function () {return view('CityManager.index');}); 
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {return view('auth.login');});

Route::get('/trainees', [TraineeController::class, 'index'])->name('Admin.Trainees.index');
Route::get('/trainees/create/', [TraineeController::class, 'create'])->name('Admin.Trainees.create');
Route::post('/trainees', [TraineeController::class, 'store'])->name('Admin.Trainees.store');
Route::delete('/trainees/{trainee}',[TraineeController::class, 'destroy'])->name('Admin.Trainees.destroy');