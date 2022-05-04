<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterDoctorController;
use App\Http\Controllers\RegisterPatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::post('/login', [LoginController::class, 'login']);
//Route::post('/logout', [LogoutController::class, 'logout']);

Route::post('/registerDoctor', RegisterDoctorController::class);
Route::post('/registerPatient', RegisterPatientController::class);
