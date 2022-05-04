<?php

use App\Http\Controllers\TrainingPackageController;
use App\Http\Controllers\TrainingSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TraineeController;

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
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('cities-list', [CityController::class, 'getCities'])->name('cities-list');
    Route::get('/cities/create/', [CityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/update/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

    Route::get('/coaches', [CoachController::class, 'index'])->name('Admin.Coaches.index');
    Route::get('/coaches/create/', [CoachController::class, 'create'])->name('Admin.Coaches.create');
    Route::post('/coaches', [CoachController::class, 'store'])->name('Admin.Coaches.store');
    Route::get('/coaches/{coach}/edit',[CoachController::class, 'edit'])->name('Admin.Coaches.edit');
    Route::put('/coaches/{coach}',[CoachController::class, 'update'])->name('Admin.Coaches.update');
    Route::delete('/coaches/{coach}',[CoachController::class, 'destroy'])->name('Admin.Coaches.destroy');

    Route::get('/trainees', [TraineeController::class, 'index'])->name('Admin.Trainees.index');
    Route::get('/trainees/create/', [TraineeController::class, 'create'])->name('Admin.Trainees.create');
    Route::post('/trainees', [TraineeController::class, 'store'])->name('Admin.Trainees.store');
    Route::delete('/trainees/{trainee}',[TraineeController::class, 'destroy'])->name('Admin.Trainees.destroy');

    Route::get('/packages', [TrainingPackageController::class, 'index'])->name('Admin.TrainingPackages.index');
    Route::get('/packages/create', [TrainingPackageController::class, 'create'])->name('Admin.TrainingPackages.create');
    Route::post('/packages', [TrainingPackageController::class, 'store'])->name('Admin.TrainingPackages.store');
    Route::get('/packages/{package}/edit', [TrainingPackageController::class, 'edit'])->name('Admin.TrainingPackages.edit');
    Route::put('/packages/{package}', [TrainingPackageController::class, 'update'])->name('Admin.TrainingPackages.update');
    Route::delete('/packages/{package}', [TrainingPackageController::class, 'destroy'])->name('Admin.TrainingPackages.destroy');

    Route::get('/sessions', [TrainingSessionController::class, 'index'])->name('Admin.TrainingSessions.index');
    Route::get('/sessions/create', [TrainingSessionController::class, 'create'])->name('Admin.TrainingSessions.create');
    Route::post('/sessions', [TrainingSessionController::class, 'store'])->name('Admin.TrainingSessions.store');
    Route::get('/sessions/{session}/edit', [TrainingSessionController::class, 'edit'])->name('Admin.TrainingSessions.edit');
    Route::put('/sessions/{session}', [TrainingSessionController::class, 'update'])->name('Admin.TrainingSessions.update');
    Route::delete('/sessions/{session}', [TrainingSessionController::class, 'destroy'])->name('Admin.TrainingSessions.destroy');

    Route::get('citiesManagers', [CityManagerController::class, 'index'])->name('citiesManagers.index');
    Route::get('cities-Managers-list', [CityManagerController::class, 'getCitiesManagers'])->name('cities-Managers-list');
    Route::get('/citiesManager/create/', [CityManagerController::class, 'create'])->name('citiesManagers.create');
    Route::post('/citiesManager', [CityManagerController::class, 'store'])->name('citiesManagers.store');
    Route::delete('/citiesManager/{cityManager}', [CityManagerController::class, 'destroy'])->name('citiesManagers.destroy');
    Route::get('/citiesManager/{cityManager}/edit', [CityManagerController::class, 'edit'])->name('citiesManagers.edit');
    Route::put('/citiesManager/{cityManager}/update', [CityManagerController::class, 'update'])->name('citiesManagers.update');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {return view('auth.login');});
