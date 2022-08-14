<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class VerifyRegisteredUserPageController extends Controller
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
        $user = User::where('id', $decryptedId)->where('status', 0)->where('userType', '!=', 1)->get();
        if(count($user)<1){
            return redirect(route('signin'))->with('error_status', 'Oops! You have entered invalid link');
        }
        return view('pages.main.auth.verify_registered_user')->with('breadcrumb','Verify User')->with('encryptedId',$id);
    }

    public function requestVerifyRegisteredUser(Request $request, $id) {
        if (Auth::check()) {
            return redirect(route('index'));
        }
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect(route('signin'))->with('error_status', 'Oops! You have entered invalid link');
        }
        $user = User::where('id', $decryptedId)->where('status', 0)->where('userType', '!=', 1)->get();
        if(count($user)<1){
            return redirect(route('signin'))->with('error_status', 'Oops! You have entered invalid link');
        }
        $validator = $request->validate([
            'otp' => 'required|integer',
        ],[
            'otp.required' => 'Please enter your otp !',
            'otp.integer' => 'Otp must be a number !',
        ]);
        $user = User::where('id', $decryptedId)->where('status', 0)->where('userType', '!=', 1)->where('otp', $request->otp)->get();
        if(count($user)<1){
            return redirect(route('verifyUser',Crypt::encryptString($decryptedId)))->with('error_status', 'Oops! Invalid OTP');
        }else{
            $user = User::where('id', $decryptedId)->where('status', 0)->where('userType', '!=', 1)->where('otp', $request->otp)->first();
            $user->status = 1;
            $user->save();
            return redirect(route('signin'))->with('success_status', 'User Verification Successful.');
        }
    }
}
