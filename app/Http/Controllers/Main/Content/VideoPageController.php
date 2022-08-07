<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\VideoModel;
use App\Models\LanguageModel;

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
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $video->whereIn('language_id', $arr);
        }
        
        $videos = $video->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.video')->with('breadcrumb','Videos')
        ->with('videos',$videos)
        ->with('languages',LanguageModel::all());
    }
}