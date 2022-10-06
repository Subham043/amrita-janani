<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use URL;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\SearchHistory;

class ProfilePageController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function index(){
        return view('pages.main.auth.user_profile')->with('breadcrumb','User Profile');
    }

    public function update(Request $req){
        $rules = array(
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email'],
            'phone' => ['nullable','regex:/^[0-9]*$/'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
        );
        if(Auth::user()->email!==$req->email){
            $rules['email'] = ['required','email','unique:users'];
        }
        if(!empty($req->phone) && Auth::user()->phone!==$req->phone){
            $rules['phone'] = ['required','regex:/^[0-9]*$/','unique:users'];
        }
        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $result = $user->save();
        if($result){
            return response()->json(["message" => "Profile Updated successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function profile_password(){
        return view('pages.main.auth.change_password')->with('breadcrumb','Change Password');
    }

    public function change_profile_password(Request $req){
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
            return response()->json(["error"=>"Please enter the correct old password"], 400);
        }
        $user->password = Hash::make($req->password);
        $result = $user->save();
        if($result){
            return response()->json(["message" => "Password Updated successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function search_history(){
        $search_history = SearchHistory::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(6)->withQueryString();
        return view('pages.main.search_history')->with('breadcrumb','User Search History')->with('search_history', $search_history);
    }

}