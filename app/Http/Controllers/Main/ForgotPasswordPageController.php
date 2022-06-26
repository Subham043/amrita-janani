<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ForgotPasswordPageController extends Controller
{
    public function index(){
        return view('pages.main.forgot_password')->with('breadcrumb','Forgot Password');
    }

    public function requestForgotPassword(Request $request) {
        if (Auth::check()) {
            return redirect(route('index'));
        }
        $validator = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->where('status', 1)->where('userType', 2)->get();
        if(count($user)<1){
            return redirect(route('forgot_password'))->with('error_status', 'Oops! You have entered invalid credentials');
        }else{
            $user = User::where('email', $request->email)->where('status', 1)->where('userType', 2)->first();
            $user->allowPasswordChange = 1;
            $user->otp = rand(1000,9999);
            $user->save();
            $encryptedId = Crypt::encryptString($user->id);

            return redirect(route('resetPassword',$encryptedId))->with('success_status', 'Kindly check your mail, we have sent you the otp.');
        }
    }
}
