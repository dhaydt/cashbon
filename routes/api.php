<?php

use App\Http\Controllers\API\ApproverController;
use App\Http\Controllers\API\CustomerController;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [RoleCheckController::class, 'check']);
Route::post('/login/pekerja', [CustomerController::class, 'login']);
Route::post('/login/approver', [ApproverController::class, 'login']);

Route::middleware(['auth:sanctum', 'customer'])->group(function () {
    Route::post('kasbon/pekerja', [CustomerController::class, 'pengajuan']);
    Route::get('kasbon/status', [CustomerController::class, 'status']);
});

Route::middleware(['auth:sanctum', 'approver'])->group(function () {
    Route::post('kasbon/update', [ApproverController::class, 'updateStatus']);
});
