<?php

use Illuminate\Support\Facades\Route;

Route::post('/', [\App\Http\Controllers\AdminUserController::class, 'store']);
Route::patch('/{id}', [\App\Http\Controllers\AdminUserController::class, 'edit']);
Route::delete('/{id}', [\App\Http\Controllers\AdminUserController::class, 'delete']);







