<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePassword;

class UserProfileController extends Controller
{
    public function profile(){
        $user = Auth::user();
        return view('user.profile',compact('user'));
    }

    public function update(){
       return view('user.update_password');
    }

    public function store(UpdatePassword $request){

        $old_password = $request->old;
        $new_password = $request->new;
        $user = Auth::guard('web')->user();

        if (Hash::check( $old_password, $user->password)) {
             $user->password = Hash::make($new_password);
             $user->update();

             return redirect()->route('profile#user')->with('update', 'Successfully Updated Password');
         }

         return back()->withErrors(['fail' => 'The old password is not correct password'])->withInput();
    }

    public function wallet(){
        $authUser = Auth::guard('web')->user();
        return view('user.wallet',compact('authUser'));
    }

    public function transfer(){
        $user = Auth::user();
        return view('user.transfer',compact('user'));
    }

      public function confirm(Request $request){
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $user = Auth::user();
        return view('user.confirm',compact('user','to_phone','amount','description'));
    }
}
