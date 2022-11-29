<?php

namespace App\Http\Controllers\Admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Models\VideoModel;
use App\Models\LanguageModel;
use App\Models\VideoLanguage;
use App\Exports\VideoExport;
use Maatwebsite\Excel\Facades\Excel;
use Uuid;
use App\Support\Types\UserType;
use App\Support\Types\LanguageType;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class VideoController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {

        $tags = VideoModel::select('tags')->whereNotNull('tags')->get();
        $tags_exist = array();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array($i, $tags_exist))){
                    array_push($tags_exist,$i);
                }
            }
        }
        $topics = VideoModel::select('topics')->whereNotNull('topics')->get();
        $topics_exist = array();
        foreach ($topics as $topic) {
            $arr = explode(",",$topic->topics);
            foreach ($arr as $i) {
                if (!(in_array($i, $topics_exist))){
                    array_push($topics_exist,$i);
                }
            }
        }

        return view('pages.admin.video.create')->with('languages', LanguageModel::all())->with("tags_exist",$tags_exist)->with("topics_exist",$topics_exist);
    }

    public function store(Request $req) {
        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'language' => ['required','array','min:1'],
            'language.*' => ['required','regex:/^[0-9]*$/'],
            'video' => ['required'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new VideoModel;
        $data->title = $req->title;
        $data->year = $req->year;
        $data->deity = $req->deity;
        $data->tags = $req->tags;
        $data->topics = $req->topics;
        $data->version = $req->version;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->video = $req->video;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        $result = $data->save();

        for($i=0; $i < count($req->language); $i++) { 
            $language = new VideoLanguage;
            $language->video_id = $data->id;
            $language->language_id = $req->language[$i];
            $language->save();
        }
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('video_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function edit($id) {
        $data = VideoModel::findOrFail($id);
        $tags = VideoModel::select('tags')->whereNotNull('tags')->get();
        $tags_exist = [];
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array($i, $tags_exist))){
                    array_push($tags_exist,$i);
                }
            }
        }
        $topics = VideoModel::select('topics')->whereNotNull('topics')->get();
        $topics_exist = [];
        foreach ($topics as $topic) {
            $arr = explode(",",$topic->topics);
            foreach ($arr as $i) {
                if (!(in_array($i, $topics_exist))){
                    array_push($topics_exist,$i);
                }
            }
        }
        return view('pages.admin.video.edit')->with('country',$data)->with('languages', LanguageModel::all())->with("tags_exist",$tags_exist)->with("topics_exist",$topics_exist);
    }

    public function update(Request $req, $id) {
        $data = VideoModel::findOrFail($id);

        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'language' => ['required','array','min:1'],
            'language.*' => ['required','regex:/^[0-9]*$/'],
            'video' => ['required'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data->title = $req->title;
        $data->year = $req->year;
        $data->deity = $req->deity;
        $data->tags = $req->tags;
        $data->topics = $req->topics;
        $data->version = $req->version;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->video = $req->video;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        $result = $data->save();

        $VideoLanguage = VideoLanguage::where('video_id',$data->id)->delete();
        for($i=0; $i < count($req->language); $i++) { 
            $language = new VideoLanguage;
            $language->video_id = $data->id;
            $language->language_id = $req->language[$i];
            $language->save();
        }
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('video_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function restoreTrash($id){
        $data = VideoModel::withTrashed()->whereNotNull('deleted_at')->findOrFail($id);
        $data->restore();
        return redirect()->intended(route('video_view_trash'))->with('success_status', 'Data Restored successfully.');
    }
    
    public function restoreAllTrash(){
        $data = VideoModel::withTrashed()->whereNotNull('deleted_at')->restore();
        return redirect()->intended(route('video_view_trash'))->with('success_status', 'Data Restored successfully.');
    }

    public function delete($id){
        $data = VideoModel::findOrFail($id);
        $data->delete();
        return redirect()->intended(route('video_view'))->with('success_status', 'Data Deleted successfully.');
    }
    
    public function deleteTrash($id){
        $data = VideoModel::withTrashed()->whereNotNull('deleted_at')->findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(route('video_view_trash'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = VideoModel::where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = VideoModel::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.video.list')->with('country', $data)->with('languages', LanguageModel::all());
    }
    
    public function viewTrash(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = VideoModel::withTrashed()->whereNotNull('deleted_at')->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = VideoModel::withTrashed()->whereNotNull('deleted_at')->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.video.list_trash')->with('country', $data)->with('languages', LanguageModel::all());
    }

    public function display($id) {
        $data = VideoModel::findOrFail($id);
        $url = "";
        return view('pages.admin.video.display')->with('country',$data)->with('languages', LanguageModel::all())->with('url',$url);
    }
    
    public function displayTrash($id) {
        $data = VideoModel::withTrashed()->whereNotNull('deleted_at')->findOrFail($id);
        $url = "";
        return view('pages.admin.video.display_trash')->with('country',$data)->with('languages', LanguageModel::all())->with('url',$url);
    }

    public function excel(){
        return Excel::download(new VideoExport, 'video.xlsx');
    }

    public function bulk_upload(){
        return view('pages.admin.video.bulk_upload');
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
        }elseif($data->count() > 30)
        {
            return response()->json(["form_error"=>"Maximum 30 rows of data in the excel are allowed."], 400);
        }else{
            foreach ($data as $key => $value) {

                $exceldata = new VideoModel;
                $exceldata->title = $value['title'];
                $exceldata->description = $value['description'];
                $exceldata->description_unformatted = $value['description'];
                $exceldata->year = $value['year'];
                $exceldata->deity = $value['deity'];
                $exceldata->tags = $value['tags'];
                $exceldata->topics = $value['topics'];
                $exceldata->version = $value['version'];
                $exceldata->video = $value['video'];
                $exceldata->status = 1;
                $exceldata->user_id = Auth::user()->id;

                switch ($value['restricted']) {
                    case 'true':
                    case 'True':
                    case 'TRUE':
                    case '1':
                    case 'restricted':
                        # code...
                        $exceldata->restricted = 1;
                        break;
                    
                    default:
                        # code...
                        $exceldata->restricted = 0;
                        break;
                }

                $result = $exceldata->save();

                $arr = array_map('strval', explode(',', $value['language']));
                for($i=0; $i < count($arr); $i++) { 
                    $languageCheck = LanguageModel::where('name','like',$arr[$i])->first();
                    if($languageCheck){
                        $language = new VideoLanguage;
                        $language->video_id = $exceldata->id;
                        $language->language_id = $languageCheck->id;
                        $language->save();
                    }
                }
                
                
            }
            return response()->json(["url"=>empty($req->refreshUrl)?route('video_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }

    }



}