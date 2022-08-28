<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Models\FAQModel;
use App\Support\Types\UserType;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function store(Request $req) {
        $rules = array(
            'question' => ['required'],
            'answer' => ['required'],
        );
        $messages = array(
            'question.required' => 'Please enter the question !',
            'answer.required' => 'Please enter the answer !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new FAQModel;
        $data->question = $req->question;
        $data->answer = $req->answer;
        $data->user_id = Auth::user()->id;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('faq_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function update(Request $req) {
        
        $rules = array(
            'id' => ['required'],
            'question' => ['required'],
            'answer' => ['required'],
        );
        $messages = array(
            'question.required' => 'Please enter the question !',
            'answer.required' => 'Please enter the answer !',
        );
        
        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }
        
        $data = FAQModel::findOrFail($req->id);
        $data->question = $req->question;
        $data->answer = $req->answer;
        $data->user_id = Auth::user()->id;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('faq_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function delete($id){
        $data = FAQModel::findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(route('faq_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view() {
        $data = FAQModel::orderBy('id', 'DESC')->get();
        return view('pages.admin.faq.list')->with('faq', $data);
    }



}