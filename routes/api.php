<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/deleted-users', [UserController::class, 'deletedList']);
    Route::patch('/restore-users', [UserController::class, 'restore']);
    Route::patch('/user/{id}', [UserController::class, 'update']);
    Route::delete('/users', [UserController::class, 'delete']);
    Route::delete('/destroy-users', [UserController::class, 'destroy']);
});



