<?php

use Illuminate\Support\Facades\Route;

Route::post('/', [\App\Http\Controllers\CompanyOfficeController::class, 'store']);
Route::patch('/{id}', [\App\Http\Controllers\CompanyOfficeController::class, 'edit']);
Route::delete('/{id}', [\App\Http\Controllers\CompanyOfficeController::class, 'delete']);







