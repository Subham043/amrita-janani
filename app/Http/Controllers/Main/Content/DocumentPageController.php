<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\DocumentModel;
use App\Models\LanguageModel;

class DocumentPageController extends Controller
{
    public function index(Request $request){
        
        if($request->has('sort')){
            if($request->input('sort')=="oldest"){
                $document = DocumentModel::orderBy('id', 'ASC');
            }elseif($request->input('sort')=="a-z"){
                $document = DocumentModel::orderBy('title', 'ASC');
            }elseif($request->input('sort')=="z-a"){
                $document = DocumentModel::orderBy('title', 'DESC');
            }else{
                $document = DocumentModel::orderBy('id', 'DESC');
            }
        }else{
            $document = DocumentModel::orderBy('id', 'DESC');
        }

        if($request->has('search')){
            $search  = $request->input('search');
            $document->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $document->whereIn('language_id', $arr);
        }
        
        $documents = $document->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.document')->with('breadcrumb','Documents')
        ->with('documents',$documents)
        ->with('languages',LanguageModel::all());
    }
}