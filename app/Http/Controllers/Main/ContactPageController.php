<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Enquiry;
use App\Jobs\SendUserThankYouEmailJob;
use App\Jobs\SendAdminEnquiryEmailJob;

class ContactPageController extends Controller
{
    public function index(){
        return view('pages.main.contact')->with('breadcrumb','Contact');
    }

    public function contact_ajax(Request $req){
        $rules = array(
            'name' => ['required','string','regex:/^[a-zA-Z\s]*$/'],
            'email' => ['required','email'],
            'phone' => ['nullable','regex:/^[0-9]*$/'],
            'subject' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'message' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'captcha' => ['required','captcha']
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.string' => 'Please enter the valid name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'subject.required' => 'Please enter the subject !',
            'subject.regex' => 'Please enter the valid subject !',
            'message.required' => 'Please enter the message !',
            'message.regex' => 'Please enter the valid message !',
            'captcha.captcha' => 'Please enter the valid captcha !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $enquiry = new Enquiry;
        $enquiry->name = $req->name;
        $enquiry->subject = $req->subject;
        $enquiry->email = $req->email;
        $enquiry->phone = $req->phone;
        $enquiry->message = $req->message;
        $result = $enquiry->save();
        if($result){
            $details['name'] = $enquiry->name;
            $details['email'] = $enquiry->email;
            $details['phone'] = $enquiry->phone;
            $details['subject'] = $enquiry->subject;
            $details['message'] = $enquiry->message;

            dispatch(new SendUserThankYouEmailJob($details));
            dispatch(new SendAdminEnquiryEmailJob($details));

            return response()->json(["message" => "Message sent successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }
}
