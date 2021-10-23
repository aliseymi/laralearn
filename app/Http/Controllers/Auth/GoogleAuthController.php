<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthenticate;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => \Str::random(16),
                    'two_factor_type' => 'off'
                ]);
            }

            if(! $user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
            }

            auth()->loginUsingId($user->id);
//            alert()->success('login successful', 'login');
            return $this->loggedIn($request,$user) ? : redirect('/');
        } catch (\Exception $e) {
            alert()->error('error', 'error');
            return redirect('/login');
        }
    }


}
