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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['status'] = 1;

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('index'))->with('success_status', 'Logged in successfully.');
        }

        return redirect(route('signin'))->with('error_status', 'Oops! You have entered invalid credentials');
    }
}
