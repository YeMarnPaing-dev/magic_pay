<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;



Route::namespace('Api')->group(function(){
    Route::get('register',[AuthController::class,'register']);
     Route::get('test',[PageController::class,'test']);
});


