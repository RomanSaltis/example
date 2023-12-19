<?php

use Illuminate\Support\Facades\Route;

Route::post('/', [\App\Http\Controllers\CarController::class, 'store']);
Route::patch('/{id}', [\App\Http\Controllers\CarController::class, 'edit']);
Route::delete('/{id}', [\App\Http\Controllers\CarController::class, 'delete']);
Route::get('/remove', [\App\Http\Controllers\CarController::class, 'removeUser']);








