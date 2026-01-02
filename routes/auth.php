<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Panel\RolesController;



////////////////auth///////////////////////////////////////

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('verify', [AuthController::class, 'verify'])->name('verify');
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum')->name('change_password');
    Route::post('check-code', [AuthController::class, 'check_code']);
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/authorize', [RolesController::class, 'authorize'])->middleware('auth:sanctum');
