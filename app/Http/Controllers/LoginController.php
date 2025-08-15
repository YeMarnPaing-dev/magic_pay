<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function user(){
         $user = Auth::guard('web')->user();
        return view('user.user',compact('user'));
    }
}
