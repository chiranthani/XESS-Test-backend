<?php

use App\Http\Controllers\OfficeExpenseController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'projects'], function () {
    Route::post('create', [ProjectController::class, 'store']);
    Route::get('{id}/cost', [ProjectController::class, 'getProjectCost']);
    Route::get('list', [ProjectController::class, 'getAllProjects']);
});

//
Route::get('staff', [StaffController::class, 'getStaffMembers']);

//
Route::get('office-expense', [OfficeExpenseController::class, 'getOfficeExpenses']);