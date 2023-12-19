<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::group([], function ()
Route::get('/verified', function () {
    return view('emails.user.verified');
});
Route::middleware('auth:api')->group(function ()
{
    Route::prefix('/car-user')->group(base_path('routes/api/carUser.php'));
    Route::prefix('/car')->group(base_path('routes/api/car.php'));
    Route::prefix('/office')->group(base_path('routes/api/office.php'));
    Route::prefix('/admin')->group(base_path('routes/api/admin.php'));
    Route::prefix('/user')->group(base_path('routes/api/user.php'));
    Route::prefix('/company')->group(base_path('routes/api/company.php'));
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
