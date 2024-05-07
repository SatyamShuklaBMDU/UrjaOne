<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CustomerComplaintController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerFeedbackController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorComplaintController;
use App\Http\Controllers\VendorConrtoller;
use App\Http\Controllers\VendorFeedbackController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('get-logout',[UserController::class,'destroy'])->name('get-logout');
    Route::get('user-profile',[CustomerController::class,'index'])->name('user-profile');
    Route::get('get/customers/{id}',[CustomerController::class,'alldata'])->name('get-customer');
    Route::post('filter-user',[CustomerController::class,'filterdata'])->name('filter-user');
    Route::post('/update-status',[CustomerController::class,'statuschange'])->name('update-status');
    Route::get('vendor-profile',[VendorConrtoller::class,'index'])->name('vendor-profile');
    Route::get('get/vendor/{id}',[VendorConrtoller::class,'alldata'])->name('get-vendor');
    Route::post('/update-status-vendor',[VendorConrtoller::class,'statuschange'])->name('update-status-vendor');
    Route::post('filter-vendor',[VendorConrtoller::class,'filterdata'])->name('filter-vendor');
    Route::get('image-verification/{id}',[VendorConrtoller::class,'imageVerification'])->name('image-verification');
    Route::post('image-remark',[VendorConrtoller::class,'ImageRemark'])->name('image-remark');

    // Faq Route
    Route::get('faq-index',[FaqController::class,'index'])->name('faq-index');
    Route::post('faq-store',[FaqController::class,'store'])->name('faqs-store');
    Route::get('/faq/edit-detail/{id}', [FaqController::class,'edit'])->name('faq-details');
    Route::post('/faq/update-status', [FaqController::class,'updateStatus'])->name('update-faq-status');
    Route::post('/faq/update-details', [FaqController::class,'update'])->name('update-faq');
    Route::delete('/faq/delete/{id}', [FaqController::class,'delete'])->name('faq-delete');
    Route::post('filter-faq',[FaqController::class,'filterdata'])->name('filter-faq');

    // Vendor Feedback Route
    Route::get('vendor-feedback',[VendorFeedbackController::class,'index'])->name('vendor-feedback');
    Route::post('/vendorreplyTofeedback', [VendorFeedbackController::class,'replyTofeedback'])->name('vendorreplyTofeedback');
    Route::post('filter-vendor-feedback',[VendorFeedbackController::class, 'filterdata'])->name('filter-vendor-feedback');
    Route::post('/update-vendor-reply', [VendorFeedbackController::class, 'updateReply'])->name('updateVendorReply');

    // Customer Feedback Route
    Route::get('customer-feedback',[CustomerFeedbackController::class,'index'])->name('customer-feedback');
    Route::post('/customerreplyTofeedback', [CustomerFeedbackController::class,'replyTofeedback'])->name('customerreplyTofeedback');
    Route::post('filter-customer-feedback',[CustomerFeedbackController::class, 'filterdata'])->name('filter-customer-feedback');
    Route::post('/update-Customer-reply', [CustomerFeedbackController::class, 'updateReply'])->name('updateCustomerReply');

    // Customer Complaint ROute
    Route::get('customer-complaint',[CustomerComplaintController::class,'index'])->name('customer-complaint');
    Route::post('/customerreplyToComplaint', [CustomerComplaintController::class,'replyToComplaint'])->name('customerreplyToComplaint');
    Route::post('/customerupdateComplaintStatus', [CustomerComplaintController::class, 'updateStatus'])->name('customerupdateComplaintStatus');
    Route::post('filter-customer-complaint',[CustomerComplaintController::class, 'filterdata'])->name('filter-customer-complaint');
    Route::post('/update-customer-reply-complaint', [CustomerComplaintController::class, 'updateReply'])->name('updateCustomerReplyComplaint');

    // Vendor Complaint Route
    Route::get('vendor-complaint',[VendorComplaintController::class,'index'])->name('vendor-complaint');
    Route::post('/vendorreplyToComplaint', [VendorComplaintController::class,'replyToComplaint'])->name('vendorreplyToComplaint');
    Route::post('/vendorupdateComplaintStatus', [VendorComplaintController::class, 'updateStatus'])->name('vendorupdateComplaintStatus');
    Route::post('filter-vendor-complaint',[VendorComplaintController::class, 'filterdata'])->name('filter-vendor-complaint');
    Route::post('/update-vendor-reply-complaint', [VendorComplaintController::class, 'updateReply'])->name('updateVendorReplyComplaint');

    // Blogs Route
    Route::get('get-blog-page',[BlogController::class,'index'])->name('get-blog-page');
    Route::get('add-blog-page',[BlogController::class,'AddBlogs'])->name('add-blog-page');
    Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::post('blogs-update', [BlogController::class, 'update'])->name('blogs.update');
    Route::post('filter-blog',[BlogController::class,'filterdata'])->name('filter-blog');
    Route::delete('/blog/delete/{id}', [BlogController::class,'delete'])->name('blog-delete');

    // Banner Route
    Route::get('main-banner-page',[BannerController::class,'index'])->name('main-banner-page');
    Route::get('vendor-main-banner-page',[BannerController::class,'VendorIndex'])->name('vendor-main-banner-page');
    Route::get('vendor-banner/{name}',[BannerController::class,'VendorBanner'])->name('vendor-banner');
    Route::get('user-banner/{name}',[BannerController::class,'UserBanner'])->name('user-banner');
    Route::post('/user-banners', [BannerController::class, 'UserStore'])->name('user.banners.store');
    Route::post('/vendor-banners', [BannerController::class, 'VendorStore'])->name('vendor.banners.store');
    Route::post('/user-edit-banners', [BannerController::class, 'UserEdit'])->name('user.banners.edit');
    Route::post('/vendor-edit-banners', [BannerController::class, 'VendorEdit'])->name('vendor.banners.edit');
    Route::delete('vendor/banner/delete/{id}', [BannerController::class,'Vendordelete'])->name('vendor-banner-delete');
});
Route::get('clear',function(){
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    echo "DONE";
});
require __DIR__.'/auth.php';
