<?php

use App\Http\Controllers\CreateSubmissionController;
use App\Http\Controllers\DeleteSubmissionController;
use App\Http\Controllers\DoctorInvitationController;
use App\Http\Controllers\DoctorTakeSubmissionController;
use App\Http\Controllers\DoSpacesController;
use App\Http\Controllers\EmailVerificationHandlerController;
use App\Http\Controllers\GetPatientInfoController;
use App\Http\Controllers\GetSubmissionController;
use App\Http\Controllers\ListPendingSubmissionController;
use App\Http\Controllers\ListSubmissionController;
use App\Http\Controllers\RegisterDoctorController;
use App\Http\Controllers\RegisterPatientController;
use App\Http\Controllers\ResendEmailVerificationController;
use App\Http\Controllers\UpdateDoctorInformationController;
use App\Http\Controllers\UpdatePatientInformation;
use App\Http\Controllers\UpdateSubmissionController;
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

Route::get('/email/verify/{id}/{hash}', EmailVerificationHandlerController::class)->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', ResendEmailVerificationController::class)->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/doctor/invite', DoctorInvitationController::class)->middleware(['auth', 'role:admin']);

Route::post('/doctor/register', RegisterDoctorController::class)->middleware('guest');

Route::get('/doctor/info', GetPatientInfoController::class)->middleware(['auth', 'role:doctor']);

Route::post('/doctor/update', UpdateDoctorInformationController::class)->middleware(['auth', 'role:doctor']);

Route::put('/doctor/take/{submission}', DoctorTakeSubmissionController::class)->middleware(['auth', 'role:doctor']);

Route::post('/doctor/prescription/{submission}', [DoSpacesController::class, 'store'])->middleware(['auth', 'role:doctor']);

Route::delete('/doctor/prescription/{submission}', [DoSpacesController::class, 'delete'])->middleware(['auth', 'role:doctor']);

Route::put('/doctor/prescription/{submission}', [DoSpacesController::class, 'update'])->middleware(['auth', 'role:doctor']);

Route::post('/patient/register', RegisterPatientController::class)->middleware('guest');

Route::get('/patient/info', GetPatientInfoController::class)->middleware(['auth', 'role:patient']);

Route::post('/patient/update', UpdatePatientInformation::class)->middleware(['auth', 'role:patient']);

Route::post('/submission/create', CreateSubmissionController::class)->middleware(['auth', 'role:patient']);

Route::get('/submission/{submission}', GetSubmissionController::class)->middleware(['auth']);

Route::put('/submission/{submission}', UpdateSubmissionController::class)->middleware(['auth', 'role:patient']);

Route::delete('/submission/{submission}', DeleteSubmissionController::class)->middleware(['auth', 'role:patient']);

Route::get('/submission/list/pending', ListPendingSubmissionController::class)->middleware(['auth', 'role:doctor']);

Route::get('/submission/list/all', ListSubmissionController::class)->middleware(['auth']);

Route::get('/submission/prescription/{submission}', [DoSpacesController::class, 'get'])->middleware(['auth']);
