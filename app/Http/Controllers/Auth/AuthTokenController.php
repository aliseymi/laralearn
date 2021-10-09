<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\User;
use App\Notifications\LoginToWebsite as LoginToWebsiteNotification;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if(!$request->session()->has('auth')){
            return redirect('/login');
        }

        $request->session()->reflash();
        return view('auth.token');
    }

    public function postToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if(!$request->session()->has('auth')){
            return redirect('/login');
        }

        $user = User::findOrFail($request->session()->get('auth.user_id'));
        $status = ActiveCode::verifyCode($request->token,$user);

        if(!$status){
            alert()->error('the code was wrong','error');
            return redirect(route('2fa.token'));
        }

        if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember'))){
            $user->activeCodes()->delete();
            $user->notify(new LoginToWebsiteNotification());
            alert()->success('You are logged in','successful');
            return redirect('/');
        }

        return redirect('/login');
    }
}
