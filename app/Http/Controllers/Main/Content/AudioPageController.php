<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\AudioModel;
use App\Models\AudioFavourite;
use App\Models\AudioAccess;
use App\Models\AudioReport;
use App\Models\LanguageModel;
use App\Models\SearchHistory;
use App\Jobs\SendAdminAccessRequestEmailJob;
use App\Jobs\SendAdminReportEmailJob;
use File;
use Illuminate\Support\Facades\Response;

class AudioPageController extends Controller
{
    public function index(Request $request){
        
        if($request->has('sort')){
            if($request->input('sort')=="oldest"){
                $audio = AudioModel::orderBy('id', 'ASC');
            }elseif($request->input('sort')=="a-z"){
                $audio = AudioModel::orderBy('title', 'ASC');
            }elseif($request->input('sort')=="z-a"){
                $audio = AudioModel::orderBy('title', 'DESC');
            }else{
                $audio = AudioModel::orderBy('id', 'DESC');
            }
        }else{
            $audio = AudioModel::orderBy('id', 'DESC');
        }

        if($request->has('search')){
            $search  = $request->input('search');
            $audio->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');

            $searchHistory = new SearchHistory;
            $searchHistory->search = $search;
            $searchHistory->user_id = Auth::user()->id;
            $searchHistory->screen = 2;
            $searchHistory->save();
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $audio->with(['Languages']);
            $audio->whereHas('Languages', function($q) use($arr) {
                $q->whereIn('language_id', $arr);
            });
        }

        if($request->has('filter')){
            $audio->with(['AudioFavourite']);
            $audio->whereHas('AudioFavourite', function($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        
        $audios = $audio->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.audio')->with('breadcrumb','Audio')
        ->with('audios',$audios)
        ->with('languages',LanguageModel::all());
    }

    public function view($uuid){
        $audio = AudioModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $audio->views = $audio->views +1;
        $audio->save();

        try {
            $audioAccess = AudioAccess::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $audioAccess = null;
        }

        return view('pages.main.content.audio_view')->with('breadcrumb','Audio - '.$audio->title)
        ->with('audioAccess',$audioAccess)
        ->with('audio',$audio);
    }

    public function audioFile($uuid){
        $audio = AudioModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

        if($audio->contentVisible()){
            $file = File::get(storage_path('app/public/upload/audios/').$audio->audio);
            $response = Response::make($file, 200);
            $response->header('Content-Type', 'audio/'.File::extension($audio->audio));
            $response->header('Cache-Control', 'public, max_age=3600');
            return $response;
        }else{
            return redirect()->intended(route('content_audio_view', $uuid));
        }
    }

    public function makeFavourite($uuid){
        $audio = AudioModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $audioFav = AudioFavourite::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->get();

        if(count($audioFav)>0){
            $audioFav = AudioFavourite::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->first();
            if($audioFav->status==1){
                $audioFav->status=0;
                $audioFav->save();
                $audio->favourites = $audio->favourites -1;

                $audio->save();
                return redirect()->intended(route('content_audio_view', $uuid));
            }else{
                $audioFav->status=1;
                $audio->favourites = $audio->favourites +1;
                $audio->save();
                $audioFav->save();
                return redirect()->intended(route('content_audio_view', $uuid));
            }
        }else{
            $audioFav = new AudioFavourite;
            $audioFav->audio_id = $audio->id;
            $audioFav->user_id = Auth::user()->id;
            $audioFav->status = 1;
            $audioFav->save();
            $audioFav->status=1;
            $audio->favourites = $audio->favourites +1;
            $audio->save();
            return redirect()->intended(route('content_audio_view', $uuid))->with('success_status', 'Made favourite successfully.');
        }

    }

    public function requestAccess(Request $req, $uuid){
        $audio = AudioModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

        $rules = array(
            'message' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'captcha' => ['required','captcha']
        );
        $messages = array(
            'message.required' => 'Please enter the reason !',
            'message.regex' => 'Please enter the valid reason !',
            'captcha.captcha' => 'Please enter the valid captcha !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $audioFav = AudioAccess::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->get();

        if(count($audioFav)>0){
            $audioFav = AudioAccess::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->first();
            $audioFav->status=0;
            $audioFav->message=$req->message;
            $audioFav->save();

            
        }else{
            $audioFav = new AudioAccess;
            $audioFav->audio_id = $audio->id;
            $audioFav->user_id = Auth::user()->id;
            $audioFav->status = 0;
            $audioFav->message=$req->message;
            $audioFav->save();
            
            $details['name'] = Auth::user()->name;
            $details['email'] = Auth::user()->email;
            $details['filename'] = $audio->title;
            $details['fileid'] = $audio->uuid;
            $details['filetype'] = 'audio';
            $details['message'] = $audioFav->message;
            dispatch(new SendAdminAccessRequestEmailJob($details));
        }

        return response()->json(["message" => "Access requested successfully."], 201);
    }

    public function report(Request $req, $uuid){
        $audio = AudioModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

        $rules = array(
            'message' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'captcha' => ['required','captcha']
        );
        $messages = array(
            'message.required' => 'Please enter the message !',
            'message.regex' => 'Please enter the valid message !',
            'captcha.captcha' => 'Please enter the valid captcha !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $audioFav = AudioReport::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->get();

        if(count($audioFav)>0){
            $audioFav = AudioReport::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->first();
            $audioFav->status = 0;
            $audioFav->message=$req->message;
            $audioFav->save();
            
        }else{
            $audioFav = new AudioReport;
            $audioFav->audio_id = $audio->id;
            $audioFav->user_id = Auth::user()->id;
            $audioFav->status = 0;
            $audioFav->message=$req->message;
            $audioFav->save();

            $details['name'] = Auth::user()->name;
            $details['email'] = Auth::user()->email;
            $details['filename'] = $audio->title;
            $details['fileid'] = $audio->uuid;
            $details['filetype'] = 'audio';
            $details['message'] = $audioFav->message;
            dispatch(new SendAdminReportEmailJob($details));
        }

        return response()->json(["message" => "Reported successfully."], 201);
    }

    public function search_query(Request $request){

        $search  = $request->phrase;
        $data = [];
        $audios = AudioModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($audios as $value) {
            if(!in_array(array("name"=>$value->title, "group"=>"Audios"), $data)){
                array_push($data,array("name"=>$value->title, "group"=>"Audios"));
            }
        }

        $tags = AudioModel::select('tags')->whereNotNull('tags')->where('tags', 'like', '%' . $search . '%')->get();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array(array("name"=>$i, "group"=>"Tags"), $data))){
                    array_push($data,array("name"=>$i, "group"=>"Tags"));
                }
            }
        }

        $searchHistory = SearchHistory::where('screen', 2)->where('search', 'like', '%' . $search . '%')->get();

        foreach ($searchHistory as $value) {
            if(!in_array(array("name"=>$value->search, "group"=>"Audios"), $data) && !in_array(array("name"=>$value->search, "group"=>"Tags"), $data)){
                array_push($data,array("name"=>$value->search, "group"=>"Previous Searches"));
            }
        }

        return response()->json(["data"=>$data], 200);
    }
}