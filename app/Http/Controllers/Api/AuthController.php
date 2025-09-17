<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\StoreUser;
use App\Http\Controllers\Controller;



class AuthController extends Controller
{
    public function register(StoreUser $request){


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->ip = $request->ip(),
        $user->user_agent=$request->server('HTTP_USER_AGENT'),
        $user->save();

        $token = $user->createToken('Magic Pay Token')->accessToken;

        return success('SuccessFully registered',['token'=> $token]);
    }
}
