<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

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

    Route::group(['prefix'=>'user','middleware'=>'usermiddleware'],function(){
    Route::get('user',[LoginController::class,'user'])->name('user#login');
    });

     Route::group(['prefix'=>'admin','middleware'=>'adminmiddleware'],function(){
    Route::get('admin',[AdminController::class,'admin'])->name('admin#login');
    });



});

require __DIR__.'/auth.php';
