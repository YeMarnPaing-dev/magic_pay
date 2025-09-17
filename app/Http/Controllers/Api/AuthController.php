<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;




class AuthController extends Controller
{
    public function register(Request $request){

          $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

       $user = new User();
$user->name = $request->name;
$user->email = $request->email;
$user->password = Hash::make($request->password);
$user->ip = $request->ip();
$user->user_agent = $request->server('HTTP_USER_AGENT');
$user->save();


        $token = $user->createToken('Magic Pay Token')->accessToken;

        return success('SuccessFully registered',['token'=> $token]);
    }

    public function login(Request $request){
        $request->validate([

            'email' => ['required', 'string'],
            'password' => ['required','string'],
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = auth()->user();
             $token = $user->createToken('Magic Pay Token')->accessToken;
               return success('SuccessFully Login',['token'=> $token]);
        }

        return fail('These Credentials do not match our record', null);

    }
}
