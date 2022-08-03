<?php

namespace App\Http\Controllers\Admin\Audio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Models\AudioModel;
use App\Models\LanguageModel;
use App\Exports\AudioExport;
use Maatwebsite\Excel\Facades\Excel;
use Uuid;
use App\Support\Types\UserType;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Storage;

class AudioController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {
        $tags = AudioModel::select('tags')->whereNotNull('tags')->get();
        $tags_exist = array();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array($i, $tags_exist))){
                    array_push($tags_exist,$i);
                }
            }
        }

        return view('pages.admin.audio.create')->with('languages', LanguageModel::all())->with("tags_exist",$tags_exist);
    }

    public function store(Request $req) {
        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'language' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'audio' => ['required','mimes:wav,mp3,aac'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
            'language.required' => 'Please enter the language !',
            'language.regex' => 'Please enter the valid language !',
            'audio.mimes' => 'Please enter a valid audio !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new AudioModel;
        $data->title = $req->title;
        $data->year = $req->year;
        $data->deity = $req->deity;
        $data->tags = $req->tags;
        $data->version = $req->version;
        $data->language_id = $req->language;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        if($req->hasFile('audio')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->audio->getClientOriginalName();
            

            $req->audio->storeAs('public/upload/audios',$newImage);
            $data->audio = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('audio_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function edit($id) {
        $data = AudioModel::findOrFail($id);
        $tags = AudioModel::select('tags')->whereNotNull('tags')->get();
        $tags_exist = [];
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array($i, $tags_exist))){
                    array_push($tags_exist,$i);
                }
            }
        }
        return view('pages.admin.audio.edit')->with('country',$data)->with('languages', LanguageModel::all())->with("tags_exist",$tags_exist);
    }

    public function update(Request $req, $id) {
        $data = AudioModel::findOrFail($id);

        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'language' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'audio' => ['nullable','mimes:wav,mp3,aac'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
            'language.required' => 'Please enter the language !',
            'language.regex' => 'Please enter the valid language !',
            'audio.mimes' => 'Please enter a valid audio !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data->title = $req->title;
        $data->year = $req->year;
        $data->deity = $req->deity;
        $data->tags = $req->tags;
        $data->version = $req->version;
        $data->language_id = $req->language;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        if($req->hasFile('audio')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->audio->getClientOriginalName();
            
            if($data->audio!=null && file_exists(storage_path('app/public/upload/audios').'/'.$data->audio)){
                unlink(storage_path('app/public/upload/audios/'.$data->audio)); 
            }

            $req->audio->storeAs('public/upload/audios',$newImage);
            $data->audio = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('audio_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function delete($id){
        $data = AudioModel::findOrFail($id);
        if($data->audio!=null && file_exists(storage_path('app/public/upload/audios').'/'.$data->audio)){
            unlink(storage_path('app/public/upload/audios/'.$data->audio)); 
        }
        $data->delete();
        return redirect()->intended(route('audio_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = AudioModel::where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%')
            ->orWhere('language_id', LanguageType::getStatusId($search))
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = AudioModel::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.audio.list')->with('country', $data)->with('languages', LanguageModel::all());
    }

    public function display($id) {
        $data = AudioModel::findOrFail($id);
        $url = "";
        return view('pages.admin.audio.display')->with('country',$data)->with('languages', LanguageModel::all())->with('url',$url);
    }

    public function excel(){
        return Excel::download(new AudioExport, 'audio.xlsx');
    }

    public function bulk_upload(){
        return view('pages.admin.audio.bulk_upload');
    }

    public function bulk_upload_store(Request $req) {
        $rules = array(
            'excel' => ['required','mimes:xls,xlsx'],
        );
        $messages = array(
            'excel.required' => 'Please select an excel !',
            'excel.mimes' => 'Please enter a valid excel !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $path = $req->file('excel')->getRealPath();
        $data = (new FastExcel)->import($path);

        if($data->count() == 0)
        {
            return response()->json(["form_error"=>"Please enter atleast one row of data in the excel."], 400);
        }elseif($data->count() > 20)
        {
            return response()->json(["form_error"=>"Maximum 20 rows of data in the excel are allowed."], 400);
        }else{
            foreach ($data as $key => $value) {
                $language = LanguageModel::where('name','like',$value['language'])->get();
                if(count($language)>0){
                    if(file_exists(storage_path('app/public/zip/audios').'/'.$value['audio'])){

                        $language = LanguageModel::where('name','like',$value['language'])->first();
                        $exceldata = new AudioModel;
                        $exceldata->title = $value['title'];
                        $exceldata->year = $value['year'];
                        $exceldata->deity = $value['deity'];
                        $exceldata->tags = $value['tags'];
                        $exceldata->version = $value['version'];
                        $exceldata->language_id = $language->id;
                        $exceldata->status = 1;
                        $exceldata->restricted = 0;
                        $exceldata->user_id = Auth::user()->id;

                        
                        $uuid = Uuid::generate(4)->string;
                        Storage::move('public/zip/audios'.'/'.$value['audio'], 'public/upload/audios'.'/'.$uuid.'-'.$value['audio']);
                        $exceldata->audio = $uuid.'-'.$value['audio'];

                        $result = $exceldata->save();
                    }
                }
                
                
            }
            return response()->json(["url"=>empty($req->refreshUrl)?route('audio_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }

    }



}