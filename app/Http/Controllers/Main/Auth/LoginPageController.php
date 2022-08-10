<?php

namespace App\Http\Controllers\Main\Auth;

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
        return view('pages.main.auth.login')->with('breadcrumb','Sign In');
    }

    public function authenticate(Request $request){
        if (Auth::check()) {
            return redirect(route('index'));
        }

        $validator = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        ],
        [
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['status'] = 1;

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('content_dashboard'))->with('success_status', 'Logged in successfully.');
        }

        return redirect(route('signin'))->with('error_status', 'Oops! You have entered invalid credentials');
    }
}
