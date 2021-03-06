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
    return 'Hello World2';
});

Route::post("/login", [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
Route::get("/employee/search", [EmployeeController::class, 'searchEmployee']);
Route::resource('/employee', EmployeeController::class);
Route::post("/logout", [LoginController::class, 'logout']);
});

