<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\CityController;

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
    //Route::get('/city_manager', function () {return view('CityManager.index');});
});
// add city routes with middleware auth

Route::group([ 'middleware' => 'auth'],function(){
    Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('cities-list', [CityController::class, 'getCities'])->name('cities-list');
    Route::get('/cities/create/', [CityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/update/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
});


// add city managers routes with middleware auth
Route::group([ 'middleware' => 'auth'],function(){
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
