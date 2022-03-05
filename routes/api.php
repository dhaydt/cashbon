<?php

use App\Http\Controllers\API\ApproverController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\RoleCheckController;
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
//..Other routes

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [RoleCheckController::class, 'check']);
Route::post('/login/pekerja', [CustomerController::class, 'login']);
Route::post('/login/approver', [ApproverController::class, 'login']);

Route::middleware(['auth:sanctum', 'customer'])->group(function () {
    Route::post('kasbon/pekerja', [CustomerController::class, 'pengajuan']);
    Route::get('kasbon/status', [CustomerController::class, 'status']);
    Route::put('firebase_token_worker', [NotificationController::class, 'firebase_token_worker']);
});

Route::middleware(['auth:sanctum', 'approver'])->group(function () {
    Route::put('firebase_token_approver', [NotificationController::class, 'firebase_token_approver']);
    Route::post('kasbon/update', [ApproverController::class, 'updateStatus']);
});
