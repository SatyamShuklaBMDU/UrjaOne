<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CustomerComplaintController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CustomerFeedbackController;
use App\Http\Controllers\API\EnquiryController;
use App\Http\Controllers\API\faqController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\VendorBannerController;
use App\Http\Controllers\API\VendorComplaintController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\VendorFeedbackController;
use App\Http\Controllers\VendorConrtoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;

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
Route::post('customer-feedback',[CustomerFeedbackController::class,'store'])->middleware('auth:sanctum');
Route::get('fetch-customer-feedback',[CustomerFeedbackController::class,'fetch'])->middleware('auth:sanctum');
Route::post('customer-complaint',[CustomerComplaintController::class,'store'])->middleware('auth:sanctum');
Route::get('fetch-customer-complaint',[CustomerComplaintController::class,'fetch'])->middleware('auth:sanctum');
Route::get('customer-profile',[CustomerController::class,'profile'])->middleware('auth:sanctum');

// FAQ Api 
Route::get('/faqs', [faqController::class,'index']);
// Vendor API
Route::post('vendor-signup',[VendorController::class,'register']);
Route::post('vendor-login',[VendorController::class,'login']);
Route::post('vendor-update',[VendorController::class,'update'])->middleware('auth:sanctum');
Route::get('vendor-profile',[VendorController::class,'profile'])->middleware('auth:sanctum');
Route::post('upload-kyc-images',[VendorController::class,'uploadImages'])->middleware('auth:sanctum');
Route::post('vendor-feedback',[VendorFeedbackController::class,'store'])->middleware('auth:sanctum');
Route::get('fetch-vendor-feedback',[VendorFeedbackController::class,'fetch'])->middleware('auth:sanctum');
Route::post('vendor-complaint',[VendorComplaintController::class,'store'])->middleware('auth:sanctum');
Route::get('fetch-vendor-complaint',[VendorComplaintController::class,'fetch'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->post('/vendor-logout', [VendorController::class,'logout']);

// Blog API
Route::get('get-blogs', [BlogController::class, 'index'])->middleware('auth:sanctum');
// Route::get('get-blogs', [BlogController::class, 'index']);

// Route for Blogs Like and Views
Route::post('blogs/{id}/views', [BlogController::class, 'incrementViews']);
Route::post('blogs/{id}/likes', [BlogController::class, 'incrementLikes']);

// Banner APi
Route::get('get-banners', [BannerController::class,'index']);
Route::get('get-vendor-banners', [VendorBannerController::class,'index']);
Route::get('get-about-banners', [BannerController::class,'Aboutindex']);
Route::get('get-vendor-about-banners', [VendorBannerController::class,'Aboutindex']);

// Notifications API
Route::get('get-user-notifications', [NotificationController::class,'userfetch']);
Route::get('get-vendor-notifications', [NotificationController::class,'vendorfetch']);

// Enquiry API
Route::post('store-enquiry',[EnquiryController::class,'store'])->middleware('auth:sanctum');
Route::get('get-enquiry-all',[EnquiryController::class,'index'])->middleware('auth:sanctum');
Route::get('get-enquiry/{id}',[EnquiryController::class,'fetchdetails'])->middleware('auth:sanctum');