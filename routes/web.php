<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

 Route::group(['prefix'=>'user','middleware'=>'usermiddleware'],function(){
    Route::get('user',[LoginController::class,'user'])->name('user#login');
    Route::get('profile',[UserProfileController::class,'profile'])->name('profile#user');
    Route::get('update-password',[UserProfileController::class,'update'])->name('update#password');
    Route::post('update-password',[UserProfileController::class,'store'])->name('password#store');

    Route::get('wallet',[UserProfileController::class,'wallet'])->name('user#wallet');
    Route::get('transfer',[UserProfileController::class,'transfer'])->name('transer#user');
    Route::get('transfer/confirm',[UserProfileController::class,'confirm'])->name(('confirm#transfer'));
    Route::post('transfer/complete',[UserProfileController::class,'transferComplete'])->name(('complete#transfer'));
    Route::get('to-account-verify', [UserProfileController::class,'verify']);
    Route::get('passwordCheck',[UserProfileController::class,'check']);

    Route::get('transaction',[UserProfileController::class,'transaction'])->name('transaction#list');
    Route::get('transaction/{trx_id}',[UserProfileController::class,'transactionDetail'])->name('transaction#detail');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix'=>'admin','middleware'=>'adminmiddleware'],function(){
    Route::get('admin',[AdminController::class,'admin'])->name('admin#login');
    Route::resource('admin-user', AdminController::class);
    Route::get('admin-user/datatable/ssd',[AdminController::class,'ssd']);

    Route::resource('user', UserController::class);
    Route::get('user/datatable/ssd',[UserController::class,'ssd']);

    Route::get('wallet',[WalletController::class,'index'])->name('wallet.index');
    Route::get('wallet/datatable/ssd',[WalletController::class,'ssd']);
    });



});

require __DIR__.'/auth.php';
