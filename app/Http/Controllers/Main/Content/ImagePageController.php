<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\ImageModel;
use App\Models\ImageFavourite;
use App\Models\ImageAccess;
use App\Models\ImageReport;
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
        
        $images = $image->where('status', 1)->paginate(6)->withQueryString();
        
        return view('pages.main.content.image')->with('breadcrumb','Images')
        ->with('images',$images)
        ->with('languages',LanguageModel::all());
    }

    public function view($uuid){
        $image = ImageModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $image->views = $image->views +1;
        $image->save();

        try {
            $imageFav = ImageFavourite::where('image_id', $image->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $imageFav = null;
        }

        try {
            $imageAccess = ImageAccess::where('image_id', $image->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $imageAccess = null;
        }

        return view('pages.main.content.image_view')->with('breadcrumb','Image - '.$image->title)
        ->with('imageAccess',$imageAccess)
        ->with('imageFav',$imageFav)
        ->with('image',$image);
    }

    public function makeFavourite($uuid){
        $image = ImageModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();
        $imageFav = ImageFavourite::where('image_id', $image->id)->where('user_id', Auth::user()->id)->get();

        if(count($imageFav)>0){
            $imageFav = ImageFavourite::where('image_id', $image->id)->where('user_id', Auth::user()->id)->first();
            if($imageFav->status==1){
                $imageFav->status=0;
                $imageFav->save();
                $image->favourites = $image->favourites -1;

                $image->save();
                return redirect()->intended(route('content_image_view', $uuid))->with('success_status', 'Made unfavourite successfully.');
            }else{
                $imageFav->status=1;
                $image->favourites = $image->favourites +1;
                $image->save();
                $imageFav->save();
                return redirect()->intended(route('content_image_view', $uuid))->with('success_status', 'Made favourite successfully.');
            }
        }else{
            $imageFav = new ImageFavourite;
            $imageFav->image_id = $image->id;
            $imageFav->user_id = Auth::user()->id;
            $imageFav->status = 1;
            $imageFav->save();
            $imageFav->status=1;
            $image->favourites = $image->favourites +1;
            $image->save();
            return redirect()->intended(route('content_image_view', $uuid))->with('success_status', 'Made favourite successfully.');
        }

    }

    public function requestAccess(Request $req, $uuid){
        $image = ImageModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

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

        $imageFav = ImageAccess::where('image_id', $image->id)->where('user_id', Auth::user()->id)->get();

        if(count($imageFav)>0){
            $imageFav = ImageAccess::where('image_id', $image->id)->where('user_id', Auth::user()->id)->first();
            $imageFav->status=0;
            $imageFav->message=$req->message;
            $imageFav->save();
            
        }else{
            $imageFav = new ImageAccess;
            $imageFav->image_id = $image->id;
            $imageFav->user_id = Auth::user()->id;
            $imageFav->status = 0;
            $imageFav->message=$req->message;
            $imageFav->save();
        }

        return response()->json(["message" => "Access requested successfully."], 201);
    }

    public function report(Request $req, $uuid){
        $image = ImageModel::where('uuid', $uuid)->where('status', 1)->firstOrFail();

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

        $imageFav = new ImageReport;
        $imageFav->image_id = $image->id;
        $imageFav->user_id = Auth::user()->id;
        $imageFav->status = 0;
        $imageFav->message=$req->message;
        $imageFav->save();

        return response()->json(["message" => "Reported successfully."], 201);
    }

}