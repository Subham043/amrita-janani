<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\DocumentModel;
use App\Models\DocumentFavourite;
use App\Models\DocumentAccess;
use App\Models\DocumentReport;
use App\Models\LanguageModel;
use App\Models\SearchHistory;

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

            $searchHistory = new SearchHistory;
            $searchHistory->search = $search;
            $searchHistory->user_id = Auth::user()->id;
            $searchHistory->screen = 3;
            $searchHistory->save();
        }

        if($request->has('language')){
            $arr = array_map('intval', explode(',', $request->input('language')));
            $document->whereIn('language_id', $arr);
        }

        if($request->has('filter')){
            $document->with(['DocumentFavourite']);
            $document->whereHas('DocumentFavourite', function($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        
        $documents = $document->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.document')->with('breadcrumb','Documents')
        ->with('documents',$documents)
        ->with('languages',LanguageModel::all());
    }

    public function view($uuid){
        $document = DocumentModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $document->views = $document->views +1;
        $document->save();

        try {
            $documentFav = DocumentFavourite::where('document_id', $document->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $documentFav = null;
        }

        try {
            $documentAccess = DocumentAccess::where('document_id', $document->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $documentAccess = null;
        }

        return view('pages.main.content.document_view')->with('breadcrumb','Document - '.$document->title)
        ->with('documentAccess',$documentAccess)
        ->with('documentFav',$documentFav)
        ->with('document',$document);
    }

    public function makeFavourite($uuid){
        $document = DocumentModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $documentFav = DocumentFavourite::where('document_id', $document->id)->where('user_id', Auth::user()->id)->get();

        if(count($documentFav)>0){
            $documentFav = DocumentFavourite::where('document_id', $document->id)->where('user_id', Auth::user()->id)->first();
            if($documentFav->status==1){
                $documentFav->status=0;
                $documentFav->save();
                $document->favourites = $document->favourites -1;

                $document->save();
                return redirect()->intended(route('content_document_view', $uuid))->with('success_status', 'Made unfavourite successfully.');
            }else{
                $documentFav->status=1;
                $document->favourites = $document->favourites +1;
                $document->save();
                $documentFav->save();
                return redirect()->intended(route('content_document_view', $uuid))->with('success_status', 'Made favourite successfully.');
            }
        }else{
            $documentFav = new DocumentFavourite;
            $documentFav->document_id = $document->id;
            $documentFav->user_id = Auth::user()->id;
            $documentFav->status = 1;
            $documentFav->save();
            $documentFav->status=1;
            $document->favourites = $document->favourites +1;
            $document->save();
            return redirect()->intended(route('content_document_view', $uuid))->with('success_status', 'Made favourite successfully.');
        }

    }

    public function requestAccess(Request $req, $uuid){
        $document = DocumentModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

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

        $documentFav = DocumentAccess::where('document_id', $document->id)->where('user_id', Auth::user()->id)->get();

        if(count($documentFav)>0){
            $documentFav = DocumentAccess::where('document_id', $document->id)->where('user_id', Auth::user()->id)->first();
            $documentFav->status=0;
            $documentFav->message=$req->message;
            $documentFav->save();
            
        }else{
            $documentFav = new DocumentAccess;
            $documentFav->document_id = $document->id;
            $documentFav->user_id = Auth::user()->id;
            $documentFav->status = 0;
            $documentFav->message=$req->message;
            $documentFav->save();
        }

        return response()->json(["message" => "Access requested successfully."], 201);
    }

    public function report(Request $req, $uuid){
        $document = DocumentModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

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

        $documentFav = DocumentReport::where('document_id', $document->id)->where('user_id', Auth::user()->id)->get();

        if(count($documentFav)>0){
            $documentFav = DocumentReport::where('document_id', $document->id)->where('user_id', Auth::user()->id)->first();
            $documentFav->status=0;
            $documentFav->message=$req->message;
            $documentFav->save();
            
        }else{
            $documentFav = new DocumentReport;
            $documentFav->document_id = $document->id;
            $documentFav->user_id = Auth::user()->id;
            $documentFav->status = 0;
            $documentFav->message=$req->message;
            $documentFav->save();
        }

        return response()->json(["message" => "Reported successfully."], 201);
    }

    public function search_query(Request $request){

        $search  = $request->phrase;
        $data = [];
        
        $documents = DocumentModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($documents as $value) {
            if(!in_array(array("name"=>$value->title), $data)){
                array_push($data,array("name"=>$value->title));
            }
            if(!in_array(array("name"=>$value->uuid), $data)){
                array_push($data,array("name"=>$value->uuid));
            }
        }

        $searchHistory = SearchHistory::where('screen', 3)->where('search', 'like', '%' . $search . '%')->get();

        foreach ($searchHistory as $value) {
            if(!in_array(array("name"=>$value->search), $data)){
                array_push($data,array("name"=>$value->search));
            }
        }

        return response()->json(["data"=>$data], 200);
    }
}