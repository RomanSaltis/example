<?php

use Illuminate\Support\Facades\Route;

Route::post('/', [\App\Http\Controllers\CarUserController::class, 'store']);
Route::patch('/{id}', [\App\Http\Controllers\CarUserController::class, 'edit']);
Route::delete('/{id}', [\App\Http\Controllers\CarUserController::class, 'delete']);







