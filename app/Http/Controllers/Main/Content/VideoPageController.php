<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\VideoModel;
use App\Models\VideoFavourite;
use App\Models\VideoAccess;
use App\Models\VideoReport;
use App\Models\LanguageModel;
use App\Models\SearchHistory;
use App\Jobs\SendAdminAccessRequestEmailJob;
use App\Jobs\SendAdminReportEmailJob;

class VideoPageController extends Controller
{
    public function index(Request $request){
        
        if($request->has('sort')){
            if($request->input('sort')=="oldest"){
                $video = VideoModel::orderBy('id', 'ASC');
            }elseif($request->input('sort')=="a-z"){
                $video = VideoModel::orderBy('title', 'ASC');
            }elseif($request->input('sort')=="z-a"){
                $video = VideoModel::orderBy('title', 'DESC');
            }else{
                $video = VideoModel::orderBy('id', 'DESC');
            }
        }else{
            $video = VideoModel::orderBy('id', 'DESC');
        }

        if($request->has('search')){
            $search  = $request->input('search');
            $video->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');

            $searchHistory = new SearchHistory;
            $searchHistory->search = $search;
            $searchHistory->user_id = Auth::user()->id;
            $searchHistory->screen = 5;
            $searchHistory->save();
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $video->with(['Languages']);
            $video->whereHas('Languages', function($q) use($arr) {
                $q->whereIn('language_id', $arr);
            });
        }

        if($request->has('filter')){
            $video->with(['VideoFavourite']);
            $video->whereHas('VideoFavourite', function($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        
        $videos = $video->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.video')->with('breadcrumb','Videos')
        ->with('videos',$videos)
        ->with('languages',LanguageModel::all());
    }

    public function view($uuid){
        $video = VideoModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $video->views = $video->views +1;
        $video->save();

        try {
            $videoAccess = VideoAccess::where('video_id', $video->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $videoAccess = null;
        }

        return view('pages.main.content.video_view')->with('breadcrumb','Video - '.$video->title)
        ->with('videoAccess',$videoAccess)
        ->with('video',$video);
    }

    public function makeFavourite($uuid){
        $video = VideoModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $videoFav = VideoFavourite::where('video_id', $video->id)->where('user_id', Auth::user()->id)->get();

        if(count($videoFav)>0){
            $videoFav = VideoFavourite::where('video_id', $video->id)->where('user_id', Auth::user()->id)->first();
            if($videoFav->status==1){
                $videoFav->status=0;
                $videoFav->save();
                $video->favourites = $video->favourites -1;

                $video->save();
                return redirect()->intended(route('content_video_view', $uuid));
            }else{
                $videoFav->status=1;
                $video->favourites = $video->favourites +1;
                $video->save();
                $videoFav->save();
                return redirect()->intended(route('content_video_view', $uuid));
            }
        }else{
            $videoFav = new VideoFavourite;
            $videoFav->video_id = $video->id;
            $videoFav->user_id = Auth::user()->id;
            $videoFav->status = 1;
            $videoFav->save();
            $videoFav->status=1;
            $video->favourites = $video->favourites +1;
            $video->save();
            return redirect()->intended(route('content_video_view', $uuid))->with('success_status', 'Made favourite successfully.');
        }

    }

    public function requestAccess(Request $req, $uuid){
        $video = VideoModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

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

        $videoFav = VideoAccess::where('video_id', $video->id)->where('user_id', Auth::user()->id)->get();

        if(count($videoFav)>0){
            $videoFav = VideoAccess::where('video_id', $video->id)->where('user_id', Auth::user()->id)->first();
            $videoFav->status=0;
            $videoFav->message=$req->message;
            $videoFav->save();
            
        }else{
            $videoFav = new VideoAccess;
            $videoFav->video_id = $video->id;
            $videoFav->user_id = Auth::user()->id;
            $videoFav->status = 0;
            $videoFav->message=$req->message;
            $videoFav->save();

            $details['name'] = Auth::user()->name;
            $details['email'] = Auth::user()->email;
            $details['filename'] = $video->title;
            $details['fileid'] = $video->uuid;
            $details['filetype'] = 'video';
            $details['message'] = $videoFav->message;
            dispatch(new SendAdminAccessRequestEmailJob($details));
        }

        return response()->json(["message" => "Access requested successfully."], 201);
    }

    public function report(Request $req, $uuid){
        $video = VideoModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

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

        $videoFav = VideoReport::where('video_id', $video->id)->where('user_id', Auth::user()->id)->get();

        if(count($videoFav)>0){
            $videoFav = VideoReport::where('video_id', $video->id)->where('user_id', Auth::user()->id)->first();
            $videoFav->status=0;
            $videoFav->message=$req->message;
            $videoFav->save();
            
        }else{
            $videoFav = new VideoReport;
            $videoFav->video_id = $video->id;
            $videoFav->user_id = Auth::user()->id;
            $videoFav->status = 0;
            $videoFav->message=$req->message;
            $videoFav->save();

            $details['name'] = Auth::user()->name;
            $details['email'] = Auth::user()->email;
            $details['filename'] = $video->title;
            $details['fileid'] = $video->uuid;
            $details['filetype'] = 'video';
            $details['message'] = $videoFav->message;
            dispatch(new SendAdminReportEmailJob($details));
        }

        return response()->json(["message" => "Reported successfully."], 201);
    }

    public function search_query(Request $request){

        $search  = $request->phrase;
        $data = [];
        
        $videos = VideoModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($videos as $value) {
            if(!in_array(array("name"=>$value->title, "group"=>"Videos"), $data)){
                array_push($data,array("name"=>$value->title, "group"=>"Videos"));
            }
        }

        $tags = VideoModel::select('tags')->whereNotNull('tags')->where('tags', 'like', '%' . $search . '%')->get();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array(array("name"=>$i, "group"=>"Tags"), $data))){
                    array_push($data,array("name"=>$i, "group"=>"Tags"));
                }
            }
        }

        $searchHistory = SearchHistory::where('screen', 5)->where('search', 'like', '%' . $search . '%')->get();

        foreach ($searchHistory as $value) {
            if(!in_array(array("name"=>$value->search, "group"=>"Videos"), $data) && !in_array(array("name"=>$value->search, "group"=>"Tags"), $data)){
                array_push($data,array("name"=>$value->search, "group"=>"Previous Searches"));
            }
        }

        return response()->json(["data"=>$data], 200);
    }
}