<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\MainController\IndexController;
use App\Http\Controllers\Api\v1\UserAdminController\UserController;
use App\Http\Controllers\Api\v1\SellerAdminController\SellerController;


Route::get('/{page?}',[IndexController::class,'pageRouter']);

Route::get('/user/{page?}',[UserController::class,'pageRouter']);

Route::get('/seller/{page?}',[SellerController::class,'pageRouter']);