<?php

use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\TraineeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});


Auth::routes(['verify'=>true]);

Route::post('/register',[RegistrationController::class, 'registerNewUser']);

Route::post('/login', [TraineeController::class, 'login'])->middleware(['auth:sanctum','verified']);

Route::post('/update/{id}', [TraineeController::class, 'update']);

Route::get('/remainingSessions',[TraineeController::class,'remaining'])->middleware(['auth:sanctum','verified']);


Route::get('/history',[TraineeController::class,'history'])->middleware(['auth:sanctum','verified']);


Route::get('/trainees/{s_id}/attend', [TraineeController::class, 'attend'])->middleware('auth:sanctum');
Route::get('/test', [TraineeController::class, 'index'])->name('Admin.Trainees.store')->middleware('auth:sanctum');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify']
)->middleware(['signed','auth:sanctum'])->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resendVerification']
)->middleware(['auth', 'throttle:6,1','auth:sanctum'])->name('verification.send');
