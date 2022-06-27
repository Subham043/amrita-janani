<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Jobs\SendForgotPasswordEmailJob;

class ForgotPasswordController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return redirect(route('dashboard'));
        }
        return view('pages.admin.auth.forgotpassword');
    }

    public function requestForgotPassword(Request $request) {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        }
        $validator = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->where('status', 1)->get();
        if(count($user)<1){
            return redirect(route('forgotPassword'))->with('error_status', 'Oops! You have entered invalid credentials');
        }else{
            $user = User::where('email', $request->email)->where('status', 1)->first();
            $user->allowPasswordChange = 1;
            $user->otp = rand(1000,9999);
            $user->save();
            $encryptedId = Crypt::encryptString($user->id);

            $details['name'] = $user->name;
            $details['email'] = $user->email;
            $details['otp'] = $user->otp;

            dispatch(new SendForgotPasswordEmailJob($details));
            return redirect(route('reset_password',$encryptedId))->with('success_status', 'Kindly check your mail, we have sent you the otp.');
        }
    }
}
