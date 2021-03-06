<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BoughtPackageController;
use App\Http\Controllers\GymManagerController;
use App\Http\Controllers\TrainingPackageController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\RevenueController;
use App\Models\BoughtPackage;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
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

Route::middleware(['auth', 'banned'])->group(function () {



    Route::get('/attendance', [AttendanceController::class, 'index'])->name('Attendance.index');
    Route::get('/attendance-dt', [AttendanceController::class, 'getAttendance'])->name('Attendance.getAttendance');

    Route::get('cities', [CityController::class, 'index'])->name('Cities.index');
    Route::get('cities-dt', [CityController::class, 'getCities'])->name('Cities.getCities');
    Route::get('/cities/create/', [CityController::class, 'create'])->name('Cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('Cities.store');
    Route::get('/cities/{city}', [CityController::class, 'show'])->name('Cities.show');
    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('Cities.edit');
    Route::put('/cities/update/{city}', [CityController::class, 'update'])->name('Cities.update');
    Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('Cities.destroy');

    Route::get('/coaches', [CoachController::class, 'index'])->name('Coaches.index');
    Route::get('/Coaches-dt', [CoachController::class, 'getCoaches'])->name('Coaches.getCoaches');
    Route::get('/coaches/create/', [CoachController::class, 'create'])->name('Coaches.create');
    Route::post('/coaches', [CoachController::class, 'store'])->name('Coaches.store');
    Route::get('/coaches/{coach}', [CoachController::class, 'show'])->name('Coaches.show');
    Route::get('/coaches/{coach}/edit', [CoachController::class, 'edit'])->name('Coaches.edit');
    Route::put('/coaches/{coach}', [CoachController::class, 'update'])->name('Coaches.update');
    Route::delete('/coaches/{coach}', [CoachController::class, 'destroy'])->name('Coaches.destroy');


    Route::get('/trainees', [TraineeController::class, 'index'])->name('Trainees.index');
    Route::get('/trainees-dt', [TraineeController::class, 'getTrainees'])->name('Trainees.getTrainees');
    Route::get('/trainees/create/', [TraineeController::class, 'create'])->name('Trainees.create');
    Route::post('/trainees', [TraineeController::class, 'store'])->name('Trainees.store');
    Route::get('/trainees/{trainee}', [TraineeController::class, 'show'])->name('Trainees.show');
    Route::delete('/trainees/{trainee}', [TraineeController::class, 'destroy'])->name('Trainees.destroy');

    Route::get('/packages', [TrainingPackageController::class, 'index'])->name('TrainingPackages.index');
    Route::get('/packages-dt', [TrainingPackageController::class, 'getTrainingPackages'])->name('TrainingPackages.getTrainingPackages');
    Route::get('/packages/create', [TrainingPackageController::class, 'create'])->name('TrainingPackages.create');
    Route::post('/packages', [TrainingPackageController::class, 'store'])->name('TrainingPackages.store');
    Route::get('/packages/{package}', [TrainingPackageController::class, 'show'])->name('TrainingPackages.show');
    Route::get('/packages/{package}/edit', [TrainingPackageController::class, 'edit'])->name('TrainingPackages.edit');
    Route::put('/packages/{package}', [TrainingPackageController::class, 'update'])->name('TrainingPackages.update');
    Route::delete('/packages/{package}', [TrainingPackageController::class, 'destroy'])->name('TrainingPackages.destroy');

    Route::get('/sessions', [TrainingSessionController::class, 'index'])->name('TrainingSessions.index');
    Route::get('/sessions-dt', [TrainingSessionController::class, 'getTrainingSessions'])->name('TrainingSessions.getTrainingSessions');
    Route::get('/sessions/create', [TrainingSessionController::class, 'create'])->name('TrainingSessions.create');
    Route::post('/sessions', [TrainingSessionController::class, 'store'])->name('TrainingSessions.store');
    Route::get('/sessions/{session}', [TrainingSessionController::class, 'show'])->name('TrainingSessions.show');
    Route::get('/sessions/{session}/edit', [TrainingSessionController::class, 'edit'])->name('TrainingSessions.edit');
    Route::put('/sessions/{session}', [TrainingSessionController::class, 'update'])->name('TrainingSessions.update');
    Route::delete('/sessions/{session}', [TrainingSessionController::class, 'destroy'])->name('TrainingSessions.destroy');

    Route::get('citiesManagers', [CityManagerController::class, 'index'])->name('citiesManagers.index');
    Route::get('cities-Managers-list', [CityManagerController::class, 'getCitiesManagers'])->name('cities-Managers-list');
    Route::get('/citiesManager/create/', [CityManagerController::class, 'create'])->name('citiesManagers.create');
    Route::post('/citiesManager', [CityManagerController::class, 'store'])->name('citiesManagers.store');
    Route::get('/citiesManager/{cityManager}', [CityManagerController::class, 'show'])->name('citiesManagers.show');
    Route::get('/citiesManager/{cityManager}/edit', [CityManagerController::class, 'edit'])->name('citiesManagers.edit');
    Route::put('/citiesManager/{cityManager}/update', [CityManagerController::class, 'update'])->name('citiesManagers.update');
    Route::delete('/citiesManager/{cityManager}', [CityManagerController::class, 'destroy'])->name('citiesManagers.destroy');

    Route::get('gyms', [GymController::class, 'index'])->name('Gyms.index');
    Route::get('gyms-dt', [GymController::class, 'getGyms'])->name('Gyms.getGyms');
    Route::get('gyms/create', [GymController::class, 'create'])->name('Gyms.create');
    Route::post('gyms', [GymController::class, 'store'])->name('Gyms.store');
    Route::get('gyms/{gym}', [GymController::class, 'show'])->name('Gyms.show');
    Route::get('gyms/{gym}/edit', [GymController::class, 'edit'])->name('Gyms.edit');
    Route::put('gyms/{gym}', [GymController::class, 'update'])->name('Gyms.update');
    Route::delete('gyms/{gym}', [GymController::class, 'destroy'])->name('Gyms.destroy');

    Route::get('/boughtpackages', [BoughtPackageController::class, 'index'])->name('Boughtpackages.index');
    Route::get('/boughtpackages/create/', [BoughtPackageController::class, 'create'])->name('Boughtpackages.create');
    Route::post('/boughtpackages', [BoughtPackageController::class, 'store'])->name('Boughtpackages.store');
    Route::delete('/boughtpackages/{boughtpackages}', [BoughtPackageController::class, 'destroy'])->name('Boughtpackages.destroy');

    Route::get('gymsManagers', [GymManagerController::class, 'index'])->name('GymManager');
    Route::get('gym-Managers-list', [GymManagerController::class, 'getGymManagers'])->name('GymManager.index');
    Route::get('gymsManagers/create', [GymManagerController::class, 'create'])->name('GymManager.create');
    Route::get('gymsManagers/create/{cityId}', [GymManagerController::class, 'getGymsOfCity']);
    Route::post('gymsManagers', [GymManagerController::class, 'store'])->name('GymManager.store');
    Route::get('gymsManagers/show/{gymManagerId}', [GymManagerController::class, 'show'])->name('GymManager.show');
    Route::delete('gymsManagers/{gymManagerId}', [GymManagerController::class, 'destroy']);
    Route::get('gymsManagers/edit/{gymManagerId}', [GymManagerController::class, 'edit'])->name('GymManager.edit');
    Route::get('gymsManagers/edit/{cityId}', [GymManagerController::class, 'getGymsOfCity']);
    Route::put('gymsManagers/{gymManagerId}', [GymManagerController::class, 'update'])->name('GymManager.update');

    Route::get('revenue', [RevenueController::class, 'index'])->name('Revenue.index');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

    Route::get('gymsManagers/{gymManagerId}', [GymManagerController::class, 'ban'])->name('GymManager.ban');
});

Route::get('/bannedGymManager', function () {
    return view('bannedGymManager');
})->name('bannedGymManager');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
