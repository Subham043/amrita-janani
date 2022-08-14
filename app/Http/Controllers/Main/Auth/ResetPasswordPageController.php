<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class ResetPasswordPageController extends Controller
{
    public function index($id){
        if (Auth::check()) {
            return redirect(route('index'));
        }
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect(route('forgot_password'))->with('error_status', 'Oops! You have entered invalid link');
        }
        $user = User::where('id', $decryptedId)->where('status', 1)->where('allowPasswordChange', 1)->where('userType', '!=', 1)->get();
        if(count($user)<1){
            return redirect(route('forgot_password'))->with('error_status', 'Oops! You have entered invalid link');
        }
        return view('pages.main.auth.reset_password')->with('breadcrumb','Reset Password')->with('encryptedId',$id);
    }

    public function requestResetPassword(Request $request, $id) {
        if (Auth::check()) {
            return redirect(route('index'));
        }
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect(route('forgot_password'))->with('error_status', 'Oops! You have entered invalid link');
        }
        $user = User::where('id', $decryptedId)->where('status', 1)->where('allowPasswordChange', 1)->where('userType', '!=', 1)->get();
        if(count($user)<1){
            return redirect(route('forgot_password'))->with('error_status', 'Oops! You have entered invalid link');
        }
        $validator = $request->validate([
            'otp' => 'required|integer',
            'password' => 'required',
            'cpassword' => 'required_with:password|same:password',
        ],[
            'otp.required' => 'Please enter your otp !',
            'otp.integer' => 'Otp must be a number !',
            'password.required' => 'Please enter your password !',
            'cpassword.required' => 'Please enter your confirm password !',
            'cpassword.same' => 'password & confirm password must be the same !',
        ]);
        $user = User::where('id', $decryptedId)->where('status', 1)->where('allowPasswordChange', 1)->where('userType', '!=', 1)->where('otp', $request->otp)->get();
        if(count($user)<1){
            return redirect(route('resetPasswordRequest',Crypt::encryptString($decryptedId)))->with('error_status', 'Oops! Invalid OTP');
        }else{
            $user = User::where('id', $decryptedId)->where('status', 1)->where('allowPasswordChange', 1)->where('userType', '!=', 1)->where('otp', $request->otp)->first();
            $user->allowPasswordChange = 0;
            $user->otp = rand(1000,9999);
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect(route('signin'))->with('success_status', 'Password Reset Successful.');
        }
    }
}
