<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ip'=>$request->ip(),
            'user_agent'=>$request->server('HTTP_USER_AGENT'),
        ]);

        event(new Registered($user));

          Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'account_number' => UUIDGenerate::accountNumber(),
                'amount'=>0, ]
            );

        Auth::login($user);

        return to_route('user#login');

    }
}
