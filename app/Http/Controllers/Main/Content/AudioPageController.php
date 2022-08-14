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
            $audio->whereIn('language_id', $arr);
        }
        
        $audios = $audio->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.audio')->with('breadcrumb','Audios')
        ->with('audios',$audios)
        ->with('languages',LanguageModel::all());
    }

    public function view($uuid){
        $audio = AudioModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $audio->views = $audio->views +1;
        $audio->save();

        try {
            $audioFav = AudioFavourite::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $audioFav = null;
        }

        try {
            $audioAccess = AudioAccess::where('audio_id', $audio->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $audioAccess = null;
        }

        return view('pages.main.content.audio_view')->with('breadcrumb','Audio - '.$audio->title)
        ->with('audioAccess',$audioAccess)
        ->with('audioFav',$audioFav)
        ->with('audio',$audio);
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
                return redirect()->intended(route('content_audio_view', $uuid))->with('success_status', 'Made unfavourite successfully.');
            }else{
                $audioFav->status=1;
                $audio->favourites = $audio->favourites +1;
                $audio->save();
                $audioFav->save();
                return redirect()->intended(route('content_audio_view', $uuid))->with('success_status', 'Made favourite successfully.');
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
            if(!in_array(array("name"=>$value->title), $data)){
                array_push($data,array("name"=>$value->title));
            }
            if(!in_array(array("name"=>$value->uuid), $data)){
                array_push($data,array("name"=>$value->uuid));
            }
        }

        $searchHistory = SearchHistory::where('screen', 2)->where('search', 'like', '%' . $search . '%')->get();

        foreach ($searchHistory as $value) {
            if(!in_array(array("name"=>$value->search), $data)){
                array_push($data,array("name"=>$value->search));
            }
        }

        return response()->json(["data"=>$data], 200);
    }
}