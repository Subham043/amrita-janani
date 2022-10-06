<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {
  
        return view('pages.admin.user.create');
    }

    public function store(Request $req) {
        $validator = $req->validate([
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'userType' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:users'],
            'phone' => ['nullable','regex:/^[0-9]*$/','unique:users'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'cpassword' => ['required_with:password|same:password'],
        ],
        [
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'userType.required' => 'Please enter the user type !',
            'userType.regex' => 'Please enter the valid user type !',
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
        $country->userType = $req->userType;
        $country->password = Hash::make($req->password);
        $country->otp = rand(1000,9999);
        $country->status = $req->status == "on" ? 1 : 2;
        $result = $country->save();
        if($result){
            return redirect()->intended(route('subadmin_view'))->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->intended(route('subadmin_create'))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($id) {
        $country = User::where('id', '!=' , Auth::user()->id)->where("userType", "!=" , 1)->findOrFail($id);
        return view('pages.admin.user.edit')->with('country',$country);
    }

    public function update(Request $req, $id) {
        $country = User::findOrFail($id);
        $rules = array(
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'userType' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email'],
            'phone' => ['nullable','regex:/^[0-9]*$/'],
            // 'password' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'userType.required' => 'Please enter the user type !',
            'userType.regex' => 'Please enter the valid user type !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'password.regex' => 'Please enter the valid password !',
        );
        if($country->email!==$req->email){
            $rules['email'] = ['required','email','unique:users'];
        }
        if(!empty($req->phone) && $country->phone!==$req->phone){
            $rules['phone'] = ['required','regex:/^[0-9]*$/','unique:users'];
        }
        // if(!empty($req->password)){
        //     $rules['cpassword'] = ['required_with:password|same:password'];
        //     $messages['cpassword.required'] = 'Please enter your confirm password !';
        //     $messages['cpassword.same'] = 'password & confirm password must be the same !';
        // }
        $validator = $req->validate($rules,$messages);

        $country->name = $req->name;
        $country->email = $req->email;
        $country->phone = $req->phone;
        $country->userType = $req->userType;
        // if(!empty($req->password)){
        //     $country->password = Hash::make($req->password);
        // }
        $country->otp = rand(1000,9999);
        $country->status = $req->status == "on" ? 1 : 2;
        $result = $country->save();
        if($result){
            return redirect()->intended(route('subadmin_edit',$country->id))->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->intended(route('subadmin_edit',$country->id))->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $country = User::where('id', '!=' , Auth::user()->id)->where("userType", "!=" , 1)->findOrFail($id);
        $country->forceDelete();
        return redirect()->intended(route('subadmin_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = User::where("id", "!=" , Auth::user()->id)->where("userType", "!=" , 1)->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = User::where('id', '!=' , Auth::user()->id)->where("userType", "!=" , 1)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.user.list')->with('country', $country);
    }

    public function display($id) {
        $country = User::where('id', '!=' , Auth::user()->id)->where("userType", "!=" , 1)->findOrFail($id);
        return view('pages.admin.user.display')->with('country',$country);
    }

    public function makeUserPreviledge($id){
        $country = User::where('id', '!=' , Auth::user()->id)->where('userType', '!=' , 1)->findOrFail($id);
        if($country->userType==2){
            $country->userType = 3; 
        }else{
            $country->userType = 2; 
        }
        $country->save(); 
        return redirect()->intended(URL::previous())->with('success_status', 'Changed user accessibility successfully.');
    }

    public function excel(){
        return Excel::download(new UserExport, 'user.xlsx');
    }

}