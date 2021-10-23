<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Recaptcha;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    use TwoFactorAuthenticate;

    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request)
    {

        try {
            $githubUser = Socialite::driver('github')->user();
            $user = \App\Models\User::where('email', $githubUser->email)->first();

            if(!$user){
                $user = \App\Models\User::create([
                    'name' => $githubUser->name,
                    'email' => $githubUser->email,
                    'password' => \Str::random(16),
                    'two_factor_type' => 'off'
                ]);
            }

            if(! $user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
            }

            auth()->loginUsingId($user->id);
//            alert()->success('login successful','login');
            return $this->loggedIn($request,$user) ? : redirect('/');
        }catch (\Exception $e){
            alert()->error('error','error');
            return redirect('login');
        }
    }
}
