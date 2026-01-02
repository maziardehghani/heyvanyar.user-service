<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\RolesController;



Route::get('/', [UserController::class, 'index']);
Route::get('show/{id}', [UserController::class, 'show']);
Route::get('detail/{id}', [UserController::class, 'detail']);
Route::put('/{user}', [UserController::class, 'update']);
Route::get('admins', [UserController::class, 'admins']);



Route::prefix('roles')->group(callback: function () {
    Route::get('/', [RolesController::class, 'index']);
    Route::post('/', [RolesController::class, 'store']);
    Route::put('/{role}', [RolesController::class, 'update']);
    Route::delete('/delete/{id}', [RolesController::class, 'delete']);
    Route::post('/assign/{user}', [RolesController::class, 'assignRole']);
    Route::post('/remove/{user}', [RolesController::class, 'revokeRole']);
    Route::post('/givePermission/{role}', [RolesController::class, 'givePermission']);
    Route::post('/revokePermission/{role}', [RolesController::class, 'revokePermission']);
    Route::get('/permissions/{role}', [RolesController::class, 'role_permissions']);
});
