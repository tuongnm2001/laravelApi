<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\ApiController;

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




Route::post('create/user', [AuthController::class , 'create']);

Route::post('login', [ApiController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::controller(ApiController::class)->group(function () {
        Route::get('getAllUsers', 'index');
        Route::post('logout', 'logout');
    });

});
