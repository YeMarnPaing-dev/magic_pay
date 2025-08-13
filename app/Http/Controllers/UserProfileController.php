<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function profile(){
        $user = Auth::user();
        return view('user.profile',compact('user'));
    }
}
