<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginPageController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return redirect(route('index'));
        }
        return view('pages.main.login')->with('breadcrumb','Sign In');
    }

    public function authenticate(Request $request){
        if (Auth::check()) {
            return redirect(route('index'));
        }

        $validator = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'captcha' => ['required','captcha']
        ],
        [
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
            'captcha.captcha' => 'Please enter the valid captcha !',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['status'] = 1;

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('index'))->with('success_status', 'Logged in successfully.');
        }

        return redirect(route('signin'))->with('error_status', 'Oops! You have entered invalid credentials');
    }
}
