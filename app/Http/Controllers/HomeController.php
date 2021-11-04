<?php

namespace App\Http\Controllers;

use App\Rules\Recaptcha;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/home');
    }

    public function comment(Request $request)
    {
        if(! $request->ajax()){
            return response()->json([
                'status' => 'just ajax request'
            ]);
        }

        $validData = $request->validate([
            'commentable_id' => 'required',
            'commentable_type' => 'required',
            'comment' => 'required',
            'parent_id' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ],[
            'g-recaptcha-response.required' => 'لطفا روی من ربات نیستم کلیک کنید',
            'comment.required' => 'لطفا نظر خود را در قسمت پیام دیدگاه وارد کنید'
        ]);

        auth()->user()->comments()->create($validData);
//        alert()->success('نظر شما با موفقیت ثبت شد');
        return response()->json([
            'status' => 'success'
        ]);
    }
}
