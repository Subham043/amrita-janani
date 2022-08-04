<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\ImageModel;
use App\Models\LanguageModel;

class ImagePageController extends Controller
{
    public function index(Request $request){
        
        if($request->has('sort')){
            if($request->input('sort')=="oldest"){
                $image = ImageModel::orderBy('id', 'ASC');
            }elseif($request->input('sort')=="a-z"){
                $image = ImageModel::orderBy('title', 'ASC');
            }elseif($request->input('sort')=="z-a"){
                $image = ImageModel::orderBy('title', 'DESC');
            }else{
                $image = ImageModel::orderBy('id', 'DESC');
            }
        }else{
            $image = ImageModel::orderBy('id', 'DESC');
        }

        if($request->has('search')){
            $search  = $request->input('search');
            $image->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $image->whereIn('language_id', $arr);
        }
        
        $images = $image->paginate(6)->withQueryString();
        
        return view('pages.main.content.image')->with('breadcrumb','Images')
        ->with('images',$images)
        ->with('languages',LanguageModel::all());
    }
}