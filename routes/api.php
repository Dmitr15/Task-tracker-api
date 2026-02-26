<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;


Route::middleware(['throttle:10,1'])->group(function () {
    Route::controller(TasksController::class)->group(function () {
        Route::post('/v1/tasks', 'store')->name('store');
        Route::get('/v1/tasks', 'index')->name('index');
        Route::get('/v1/tasks/{id}', 'show')->name('show');
        Route::patch('/v1/tasks/{id}', 'update')->name('update');
        Route::delete('/v1/tasks/{id}', 'destroy')->name('destroy');
    });
});