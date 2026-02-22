<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\RolesController;
use App\Http\Controllers\Panel\PermissionsController;



Route::get('/', [UserController::class, 'index']);
Route::get('get/{id}', [UserController::class, 'show']);
Route::get('show/by-mobile/{mbile}', [UserController::class, 'getByMobile']);
Route::get('detail/{id}', [UserController::class, 'detail']);
Route::put('/{user}', [UserController::class, 'update']);
Route::get('admins', [UserController::class, 'admins']);
Route::get('list/', [UserController::class, 'usersList']);



Route::prefix('roles')->group(callback: function () {
    Route::get('/', [RolesController::class, 'index']);
    Route::post('/', [RolesController::class, 'store']);
    Route::put('/{role}', [RolesController::class, 'update']);
    Route::delete('/delete/{role}', [RolesController::class, 'delete']);
    Route::post('/assign/{user}', [RolesController::class, 'assignRole']);
    Route::post('/revoke/{user}', [RolesController::class, 'revokeRole']);
    Route::post('/give-permission/{role}', [RolesController::class, 'givePermission']);
    Route::post('/revoke-permission/{role}', [RolesController::class, 'revokePermission']);
    Route::get('/permissions/{role}', [RolesController::class, 'rolePermissions']);
});



////////////////permissions///////////////////////////////////////
Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionsController::class, 'index']);
    Route::get('/show/{permission}', [PermissionsController::class, 'show']);
});


