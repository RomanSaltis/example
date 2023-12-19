<?php

use Illuminate\Support\Facades\Route;

Route::post('/', [\App\Http\Controllers\CompanyController::class, 'store']);
Route::patch('/{id}', [\App\Http\Controllers\CompanyController::class, 'edit']);
Route::delete('/{id}', [\App\Http\Controllers\CompanyController::class, 'delete']);
Route::get('/find_company_name', [\App\Http\Controllers\CompanyController::class, 'findCompanyName'])->withoutMiddleware('auth:api');

