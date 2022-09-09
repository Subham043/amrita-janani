<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Uuid;
use Image;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\BannerQuoteModel;
use Illuminate\Support\Facades\Validator;

class BannerQuoteController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function banner_quote(){
        return view('pages.admin.banner.banner_quote')->with('quotes', BannerQuoteModel::orderBy('id', 'DESC')->get());
    }

    public function storeBannerQuote(Request $req){

        $rules = array(
            'quote' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'quote.required' => 'Please enter the quote !',
            'quote.regex' => 'Please enter the valid quote !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new BannerQuoteModel;
        $data->user_id = Auth::user()->id;
        $data->quote = $req->quote;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('banner_quote_view'):$req->refreshUrl, "message" => "Data updated successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }
    

    public function deleteBannerQuote($id){
        $data = BannerQuoteModel::findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(URL::previous())->with('success_status', 'Data Deleted permanently.');
    }

    
}