<?php

use App\Http\Controllers\TrainingPackageController;
use Illuminate\Support\Facades\Route;

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
Route::get('/packages', [TrainingPackageController::class, 'index'])->name('Admin.TrainingPackages.index');
Route::get('/packages/create', [TrainingPackageController::class, 'create'])->name('Admin.TrainingPackages.create');
Route::post('/packages', [TrainingPackageController::class, 'store'])->name('Admin.TrainingPackages.store');
Route::get('/packages/{package}', [TrainingPackageController::class, 'show'])->name('Admin.TrainingPackages.show');
Route::get('/packages/{package}/edit', [TrainingPackageController::class, 'edit'])->name('Admin.TrainingPackages.edit');
Route::put('/packages/{package}', [TrainingPackageController::class, 'update'])->name('Admin.TrainingPackages.update');
Route::delete('/packages/{package}', [TrainingPackageController::class, 'destroy'])->name('Admin.TrainingPackages.destroy');

