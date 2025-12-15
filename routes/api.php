<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::get('/external/users', [UserController::class, 'getUsers']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'index'])
        ->middleware('isAuthorized:get_users');
    Route::get('/user/{user}', [UserController::class, 'show'])->middleware('isAuthorized:get_user');
    Route::post('/user', [UserController::class, 'store'])
        ->middleware('isAuthorized:create_user');
    Route::patch('/user/{user}', [UserController::class, 'update'])
        ->middleware('isAuthorized:update_user');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])
        ->middleware('isAuthorized:delete_user');
    Route::post('/assign-permission/{role}', [UserController::class, 'assignPermission']);
    Route::post('/assign-role/{user}', [UserController::class, 'assignRole']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
