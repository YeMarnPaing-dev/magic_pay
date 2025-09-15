<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $user = auth()->guard('web')->user();
         $notification = $user->notifications()->paginate(10);

    return view('user.notification',compact('notification'));
    }
}
