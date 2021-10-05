<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use App\Models\User;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function manageTwoFactor()
    {
        return view('profile.two_factor_auth');
    }

    public function postTwoFactor(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => ['required_unless:type,off',Rule::unique('users','phone_number')->ignore($request->user()->id)]
        ]);

        if($data['type'] === 'sms'){
            if($request->user()->phone_number !== $data['phone']){
                // generate the code
                // send to user mobile
                $code = ActiveCode::generateCode($request->user());
                $request->session()->flash('phone',$data['phone']);
                $request->user()->notify(new ActiveCodeNotification($code,$data['phone']));
                return redirect(route('profile.2fa.phone'));
            }else{
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            }
        }

        if($data['type'] === 'off'){
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }

        return back();
    }

    public function getPhoneVerify(Request $request)
    {
        if(!$request->session()->has('phone')){
            return redirect(route('profile.2fa.manage'));
        }
        $request->session()->reflash();
        return view('profile.phone_verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if(!$request->session()->has('phone')){
            return redirect(route('profile.2fa.manage'));
        }

        $status = ActiveCode::verifyCode($request->token,$request->user());

        if($status){
            $request->user()->activeCodes()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);
            alert()->success('successful','success');
        }else{
            alert()->error('error','error');
        }

        return redirect(route('profile.2fa.manage'));
    }

}
