<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorConrtoller;
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
});

require __DIR__.'/auth.php';
