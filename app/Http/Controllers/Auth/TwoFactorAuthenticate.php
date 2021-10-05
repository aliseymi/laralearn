<?php

namespace App\Http\Controllers\Auth;

use App\Models\ActiveCode;
use App\Notifications\LoginToWebsiteNotification;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedIn(Request $request,$user)
    {
        if($user->hasTwoFactorAuthenticationEnabled()){
            auth()->logout();

            $request->session()->flash('auth',[
                'user_id' => $user->id,
                'using_sms' => false,
                'remember' => $request->has('remember')
            ]);

            if($user->two_factor_type == 'sms'){

                $code = ActiveCode::generateCode($user);
                // TODO send sms
                $request->session()->push('auth.using_sms',true);
            }

            return redirect(route('2fa.token'));
        }

        $user->notify(new LoginToWebsiteNotification());

        return false;
    }
}
