<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\AudioModel;
use App\Models\LanguageModel;

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
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $audio->whereIn('language_id', $arr);
        }
        
        $audios = $audio->paginate(6)->withQueryString();
        
        return view('pages.main.content.audio')->with('breadcrumb','Audios')
        ->with('audios',$audios)
        ->with('languages',LanguageModel::all());
    }
}