<?php

namespace App\Http\Controllers\Admin\Enquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\Enquiry;
use App\Exports\EnquiryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendAdminEnquiryReplyEmailJob;

class EnquiryController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function delete($id){
        $country = Enquiry::findOrFail($id);
        $country->forceDelete();
        return redirect()->intended(route('enquiry_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = Enquiry::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('subject', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = Enquiry::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.enquiry.list')->with('country', $country);
    }

    public function display($id) {
        $country = Enquiry::findOrFail($id);
        return view('pages.admin.enquiry.display')->with('country',$country);
    }
    
    public function reply(Request $req, $id) {
        $country = Enquiry::findOrFail($id);
        $rules = array(
            'subject' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'message' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'subject.required' => 'Please enter the subject !',
            'subject.regex' => 'Please enter the valid subject !',
            'message.required' => 'Please enter the message !',
            'message.regex' => 'Please enter the valid message !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $details['name'] = $country->name;
        $details['email'] = $country->email;
        $details['subject'] = $req->subject;
        $details['message'] = $req->message;

        dispatch(new SendAdminEnquiryReplyEmailJob($details));
        return response()->json(["message" => "Replied successfully."], 200);
    }

    public function excel(){
        return Excel::download(new EnquiryExport, 'enquiry.xlsx');
    }

}