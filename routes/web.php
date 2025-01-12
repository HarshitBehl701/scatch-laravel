<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\MainController\IndexController;
use App\Http\Controllers\Api\v1\UserAdminController\UserController;
use App\Http\Controllers\Api\v1\SellerAdminController\SellerController;
use App\Http\Controllers\Api\v1\ProductController\ProductController;
use Illuminate\Support\Facades\Session;
use  App\Http\Middleware\Api\v1\AuthMiddleware\AuthMiddleware;
use  App\Http\Middleware\Api\v1\AuthMiddleware\LoginRegisterPageMiddleware;

//Common Routes
Route::get('/logout',function(){
    Session::flush();
    return redirect('/home')->with('success','User Logout  Successfully');
});

Route::get('/{loginRegisterPage}',[IndexController::class,'loginRegisterPageRouter'])->where('loginRegisterPage','login|register|seller-login|seller-register')->middleware(LoginRegisterPageMiddleware::class);
Route::get('/{page?}',[IndexController::class,'pageRouter']);

//User Routes

//Get Routes
Route::get('/user/{page?}/{param1?}/{param2?}',[UserController::class,'pageRouter'])->middleware(AuthMiddleware::class.':user');
//Get Routes

//Post Routes
Route::post('/user/register',[UserController::class,'register'])->name('user.register');
Route::post('/user/login',[UserController::class,'login'])->name('user.login');
Route::post('/user/update-profile',[UserController::class,'updateProfile'])->name('user.updateProfile');
Route::post('/user/update-image',[UserController::class,'uploadProfileImage'])->name('user.uploadProfileImage');
//Post Routes


//Seller  Routes

//Get Routes
Route::get('/seller/{page?}/{param1?}/{param2?}',[SellerController::class,'pageRouter'])->middleware(AuthMiddleware::class.':seller');
//Get Routes

//Post Routes
Route::post('/seller/register',[SellerController::class,'register'])->name('seller.register');
Route::post('/seller/login',[SellerController::class,'login'])->name('seller.login');
Route::post('/seller/update-profile',[SellerController::class,'updateProfile'])->name('seller.updateProfile');
Route::post('/seller/update-image',[SellerController::class,'uploadProfileImage'])->name('seller.uploadProfileImage');
//Post Routes



//Product Routes

//Get  Routes
Route::get('/product/status-update/{productId}',[ProductController::class,'updateProductStatus'])->name('product.updateProductStatus')->middleware(AuthMiddleware::class.':seller');
//Get  Routes

//Post  Routes
Route::post('/product/create',[ProductController::class,'createProduct'])->name('product.create')->middleware(AuthMiddleware::class.':seller');
Route::post('/product/update-product/{productId}',[ProductController::class,'updateProduct'])->name('product.update')->middleware(AuthMiddleware::class.':seller');
//Post  Routes