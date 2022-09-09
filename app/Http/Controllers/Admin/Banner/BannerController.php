<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Uuid;
use Image;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\BannerModel;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function banner(){
        return view('pages.admin.banner.banner')->with('images', BannerModel::all());
    }

    public function storeBanner(Request $req){

        $rules = array(
            'image' => ['required','image','mimes:jpeg,png,jpg,webp'],
        );
        $messages = array(
            'image.image' => 'Please enter a valid image !',
            'image.mimes' => 'Please enter a valid image !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new BannerModel;
        $data->user_id = Auth::user()->id;

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();
            
            
            $img = Image::make($req->file('image')->getRealPath());
            $img->resize(300, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/upload/banners').'/'.'compressed-'.$newImage);

            $req->image->storeAs('public/upload/banners',$newImage);
            $data->image = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('banner_view'):$req->refreshUrl, "message" => "Data updated successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }
    

    public function deleteBanner($id){
        $data = BannerModel::findOrFail($id);
        if($data->image!=null && file_exists(storage_path('app/public/upload/banners').'/'.$data->image)){
            unlink(storage_path('app/public/upload/banners/'.$data->image)); 
            unlink(storage_path('app/public/upload/banners/compressed-'.$data->image)); 
        }
        $data->forceDelete();
        return redirect()->intended(URL::previous())->with('success_status', 'Data Deleted permanently.');
    }

    
}