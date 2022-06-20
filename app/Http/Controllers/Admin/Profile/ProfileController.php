<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use URL;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function index(){
        return view('pages.admin.profile.index');
    }

    public function update(Request $req){
        $rules = array(
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
        );
        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $req->name;
        $result = $user->save();
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('profile'):$req->refreshUrl, "message" => "Profile Updated successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function profile_password(Request $req){
        $rules = array(
            'opassword' => 'required',
            'password' => 'required',
            'cpassword' => 'required_with:password|same:password',
        );
        $messages = array(
            'opassword.required' => 'Please enter your old password !',
            'password.required' => 'Please enter your password !',
            'cpassword.required' => 'Please enter your confirm password !',
            'cpassword.same' => 'password & confirm password must be the same !',
        );
        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }
        $user = User::findOrFail(Auth::user()->id);
        if(!Hash::check($req->opassword, $user->getPassword())){
            return response()->json(["message"=>"Please enter the correct old password"], 400);
        }
        $user->password = Hash::make($req->password);
        $result = $user->save();
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('profile'):$req->refreshUrl, "message" => "Password Updated successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

}