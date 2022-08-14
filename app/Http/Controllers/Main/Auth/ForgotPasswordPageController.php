<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Jobs\SendForgotPasswordEmailJob;

class ForgotPasswordPageController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return redirect(route('index'));
        }
        return view('pages.main.auth.forgot_password')->with('breadcrumb','Forgot Password');
    }

    public function requestForgotPassword(Request $request) {
        if (Auth::check()) {
            return redirect(route('index'));
        }
        
        $validator = $request->validate([
            'email' => ['required','email'],
        ],
        [
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
        ]);

        $user = User::where('email', $request->email)->where('status', 1)->where('userType', '!=', 1)->get();
        if(count($user)<1){
            return redirect(route('forgot_password'))->with('error_status', 'Oops! You have entered invalid credentials');
        }else{
            $user = User::where('email', $request->email)->where('status', 1)->where('userType', '!=', 1)->first();
            $user->allowPasswordChange = 1;
            $user->otp = rand(1000,9999);
            $user->save();
            $encryptedId = Crypt::encryptString($user->id);

            $details['name'] = $user->name;
            $details['email'] = $user->email;
            $details['otp'] = $user->otp;

            dispatch(new SendForgotPasswordEmailJob($details));

            return redirect(route('resetPassword',$encryptedId))->with('success_status', 'Kindly check your mail, we have sent you the otp.');
        }
    }
}
