<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Models\LanguageModel;
use App\Exports\LanguageExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Support\Types\UserType;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {

        return view('pages.admin.language.create');
    }

    public function store(Request $req) {
        $rules = array(
            'name' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new LanguageModel;
        $data->name = $req->name;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('language_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function edit($id) {
        $data = LanguageModel::findOrFail($id);
        
        return view('pages.admin.language.edit')->with('country',$data);
    }

    public function update(Request $req, $id) {
        $data = LanguageModel::findOrFail($id);

        $rules = array(
            'name' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data->name = $req->name;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('language_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function delete($id){
        $data = LanguageModel::findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(route('language_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = LanguageModel::where('title', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = LanguageModel::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.language.list')->with('country', $data);
    }

    public function display($id) {
        $data = LanguageModel::findOrFail($id);
        $url = "";
        return view('pages.admin.language.display')->with('country',$data)->with('url',$url);
    }

    public function excel(){
        return Excel::download(new LanguageExport, 'language.xlsx');
    }



}