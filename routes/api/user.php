<?php

use Illuminate\Support\Facades\Route;

Route::post('/issue', [\App\Http\Controllers\UserController::class, 'issueToken'])->withoutMiddleware('auth:api');
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->withoutMiddleware('auth:api');
Route::get('/verify', [\App\Http\Controllers\UserController::class, 'verify'])->withoutMiddleware('auth:api');
Route::get('/me', [\App\Http\Controllers\UserController::class, 'me']);
Route::get('/test', [\App\Http\Controllers\UserController::class, 'test'])->middleware('language')->withoutMiddleware('auth:api');
Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->withoutMiddleware('auth:api');;
Route::patch('/{id}', [\App\Http\Controllers\UserController::class, 'edit']);
Route::delete('/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
Route::get('/{id}', [\App\Http\Controllers\UserController::class, 'user']);






