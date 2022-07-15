<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Support\For\UserType;
use App\Exports\SubAdminExport;
use Maatwebsite\Excel\Facades\Excel;
use Image;

class SubAdminController extends Controller
{
    public function create() {
  
        return view('pages.admin.subadmin.create')->with('users', UserType::lists());
    }

    public function store(Request $req) {
        $validator = $req->validate([
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:users'],
            'phone' => ['required','regex:/^[0-9]*$/','unique:users'],
            'userType' => ['required','regex:/^[0-9]*$/'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        ],
        [
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'userType.required' => 'Please enter the user type!',
            'userType.regex' => 'Please enter the valid user type!',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
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
        $country = User::findOrFail($id);
        return view('pages.admin.subadmin.edit')->with('country',$country)->with('users', UserType::lists());
    }

    public function update(Request $req, $id) {
        $country = User::findOrFail($id);
        $rules = array(
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email'],
            'phone' => ['required','regex:/^[0-9]*$/'],
            'userType' => ['required','regex:/^[0-9]*$/'],
            'password' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'userType.required' => 'Please enter the user type!',
            'userType.regex' => 'Please enter the valid user type!',
            'password.regex' => 'Please enter the valid password !',
        );
        if($country->email!==$req->email){
            $rules['email'] = ['required','email','unique:users'];
        }
        if($country->phone!==$req->phone){
            $rules['phone'] = ['required','regex:/^[0-9]*$/','unique:users'];
        }
        $validator = $req->validate($rules,$messages);

        $country->name = $req->name;
        $country->email = $req->email;
        $country->phone = $req->phone;
        $country->userType = $req->userType;
        $country->password = Hash::make($req->password);
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
        $country = User::findOrFail($id);
        $country->delete();
        return redirect()->intended(route('subadmin_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = User::where("userType", "!=" , 5)->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('userType', UserType::getStatusId($search))
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = User::where('userType', '!=' , 5)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.subadmin.list')->with('country', $country)->with('users', UserType::lists());
    }

    public function display($id) {
        $country = User::findOrFail($id);
        return view('pages.admin.subadmin.display')->with('country',$country)->with('users', UserType::lists());
    }

    public function excel(){
        return Excel::download(new SubAdminExport, 'subadmin.xlsx');
    }
}
