<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Notifications\ActiveCode as ActiveCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class twoFactorAuthController extends Controller
{
    public function manageTwoFactor()
    {
        return view('profile.two_factor_auth');
    }

    public function postTwoFactor(Request $request)
    {
        $data = $this->validateRequestData($request);

        if($this->isTwoFactorTypeSms($data)){
            if($request->user()->phone_number !== $data['phone']){
                return $this->createCodeAndSendToUser($request, $data);
            }else{
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            }
        }

        if($this->isTwoFactorTypeOff($data)){
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }

        return back();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateRequestData(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => ['required_unless:type,off', Rule::unique('users', 'phone_number')->ignore($request->user()->id)]
        ]);
        return $data;
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isTwoFactorTypeSms(array $data): bool
    {
        return $data['type'] === 'sms';
    }

    /**
     * @param Request $request
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function createCodeAndSendToUser(Request $request, array $data)
    {
        $code = ActiveCode::generateCode($request->user());

        $request->session()->flash('phone', $data['phone']);

        $request->user()->notify(new ActiveCodeNotification($code, $data['phone']));

        return redirect(route('profile.2fa.phone'));
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isTwoFactorTypeOff(array $data): bool
    {
        return $data['type'] === 'off';
    }
}
