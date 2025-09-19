<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;



Route::namespace('Api')->group(function(){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);

    Route::middleware('auth:api')->group(function(){
    Route::get('profile',[PageController::class,'profile']);
     Route::post('logout',[AuthController::class,'logout']);
     Route::get('transaction',[PageController::class,'transaction']);
      Route::get('transaction/{trx_id}',[PageController::class,'transaction_detail']);
    });


});


