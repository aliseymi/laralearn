<?php

namespace App\Http\Controllers\Auth;

use App\Models\ActiveCode;
use App\Notifications\ActiveCode as ActiveCodeNotification;
use App\Notifications\LoginToWebsite as LoginToWebsiteNotification;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedIn(Request $request,$user)
    {
        if($user->hasTwoFactorAuthenticationEnabled()){
            return $this->logoutAndSendSms($request, $user);
        }

        $user->notify(new LoginToWebsiteNotification());

        return false;
    }

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function logoutAndSendSms(Request $request, $user)
    {
        auth()->logout();

        $request->session()->flash('auth', [
            'user_id' => $user->id,
            'using_sms' => false,
            'remember' => $request->has('remember')
        ]);

        if ($user->hasSmsTwoFactorAuthenticationEnabled()) {

            $code = ActiveCode::generateCode($user);
            $user->notify(new ActiveCodeNotification($code, $user->phone_number));
            $request->session()->push('auth.using_sms', true);
        }

        return redirect(route('2fa.token'));
    }
}
