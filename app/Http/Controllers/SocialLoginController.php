<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
         $data = Socialite::driver($provider)->user();
        //  dd($data->toArray());

    // $user = User::updateOrCreate([
    //     'github_id' => $githubUser->id,
    // ], [
    //     'name' => $githubUser->name,
    //     'email' => $githubUser->email,
    //     'github_token' => $githubUser->token,
    //     'github_refresh_token' => $githubUser->refreshToken,
    // ]);

    // Auth::login($user);

    // return redirect('/dashboard');
    }
}
