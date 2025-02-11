<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\TodoController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::group(['prefix'=>'v1'], function(){

        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
        });
        Route::middleware([JwtMiddleware::class])->group(function () {
            Route::get('resume', [ResumeController::class, 'resume']);

            Route::get('users', [AuthController::class, 'users']);
            Route::get('me', [AuthController::class, 'me']);

            Route::controller(TodoController::class)->group(function () {
                Route::get('todos', 'index');
                Route::post('todo', 'store');
                Route::get('todo/{id}', 'show');
                Route::put('todo/{id}', 'update');
                Route::put('todo/{id}/mark', 'mark');
                Route::delete('todo/{id}', 'destroy');
            });
        });
    });
});
