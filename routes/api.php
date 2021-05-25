<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', function () {
    return 'Hello World';
});

Route::get("/login", [LoginController::class, 'create']);
Route::post("/login", [LoginController::class, 'login']);
Route::get("/logout", [LoginController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
Route::apiResource('/employee', EmployeeController::class);
});

