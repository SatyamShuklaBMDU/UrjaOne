<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\faqController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\VendorConrtoller;
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

// FAQ Api 
Route::get('/faqs', [faqController::class,'index']);
// Vendor API
Route::post('vendor-register',[VendorController::class,'register']);
Route::post('vendor-login',[VendorController::class,'login']);
Route::post('vendor-update',[VendorController::class,'update'])->middleware('auth:sanctum');
Route::post('upload-kyc-images',[VendorController::class,'uploadImages'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->post('/vendor-logout', [VendorController::class,'logout']);