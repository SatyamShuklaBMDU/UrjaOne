<?php

use App\Http\Controllers\API\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/users',[CustomerController::class,'register']);
Route::post('login',[CustomerController::class,'login']);
Route::middleware('auth:sanctum')->post('/logout', [CustomerController::class,'logout']);
Route::post('user-update',[CustomerController::class,'update'])->middleware('auth:sanctum');
