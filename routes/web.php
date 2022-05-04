<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CoachController; 

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

Route::get('/coaches', [CoachController::class, 'index'])->name('Admin.Coaches.index');
Route::get('/coaches/create/', [CoachController::class, 'create'])->name('Admin.Coaches.create');
Route::post('/coaches', [CoachController::class, 'store'])->name('Admin.Coaches.store');
Route::get('/coaches/{coach}/edit',[CoachController::class, 'edit'])->name('Admin.Coaches.edit');
Route::put('/coaches/{coach}',[CoachController::class, 'update'])->name('Admin.Coaches.update');
Route::delete('/coaches/{coach}',[CoachController::class, 'destroy'])->name('Admin.Coaches.destroy');