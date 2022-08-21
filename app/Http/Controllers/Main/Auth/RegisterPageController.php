<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendVerificationEmailJob;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RegisterPageController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return redirect(route('index'));
        }
        return view('pages.main.auth.register')->with('breadcrumb','Sign Up');
    }

    public function store(Request $req) {
        $validator = $req->validate([
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:users'],
            'phone' => ['nullable','regex:/^[0-9]*$/','unique:users'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'cpassword' => ['required_with:password|same:password'],
        ],
        [
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
            'cpassword.required' => 'Please enter your confirm password !',
            'cpassword.same' => 'password & confirm password must be the same !',
        ]);

        $country = new User;
        $country->name = $req->name;
        $country->email = $req->email;
        $country->phone = $req->phone;
        $country->userType = 2;
        $country->password = Hash::make($req->password);
        $country->otp = rand(1000,9999);
        $country->status = 0;
        $result = $country->save();
        $encryptedId = Crypt::encryptString($country->id);

        $details['name'] = $country->name;
        $details['email'] = $country->email;
        $details['otp'] = $country->otp;

        dispatch(new SendVerificationEmailJob($details));

        if($result){
            return redirect(route('verifyUser', $encryptedId))->with('success_status', 'Kindly check your mail, we have sent you the otp..');
        }else{
            return redirect(route('signup'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
