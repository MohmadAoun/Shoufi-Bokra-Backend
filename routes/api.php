<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Middleware\EventAccessMiddleware;

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('update', [PassportAuthController::class, 'update'])->middleware('auth:api');
Route::get('user', [PassportAuthController::class, 'getUser'])->middleware('auth:api');

// Routes without the 'auth:api' middleware
Route::middleware('auth:api')->group(function () {
    Route::resource('events', EventController::class)->middleware(EventAccessMiddleware::class);
});
