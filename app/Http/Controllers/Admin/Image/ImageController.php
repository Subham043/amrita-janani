<?php

namespace App\Http\Controllers\Admin\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Models\ImageModel;
use App\Exports\ImageExport;
use Maatwebsite\Excel\Facades\Excel;
use Image;
use Uuid;
use App\Support\Types\UserType;
use App\Support\Types\LanguageType;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function create() {
        $tags = ImageModel::select('tags')->whereNotNull('tags')->get();
        $tags_exist = array();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array($i, $tags_exist))){
                    array_push($tags_exist,$i);
                }
            }
        }

        return view('pages.admin.image.create')->with('languages', LanguageType::lists())->with("tags_exist",$tags_exist);
    }

    public function store(Request $req) {
        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'language' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'image' => ['required','image','mimes:jpeg,png,jpg,webp'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
            'language.required' => 'Please enter the language !',
            'language.regex' => 'Please enter the valid language !',
            'image.image' => 'Please enter a valid image !',
            'image.mimes' => 'Please enter a valid image !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new ImageModel;
        $data->title = $req->title;
        $data->year = $req->year;
        $data->deity = $req->deity;
        $data->tags = $req->tags;
        $data->version = $req->version;
        $data->language = $req->language;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();
            
            
            $img = Image::make($req->file('image')->getRealPath());
            $img->resize(300, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('upload/images').'/'.'compressed-'.$newImage);

            $req->image->move(public_path('upload/images'), $newImage);
            $data->image = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('image_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function edit($id) {
        $data = ImageModel::findOrFail($id);
        $tags = ImageModel::select('tags')->whereNotNull('tags')->get();
        $tags_exist = [];
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array($i, $tags_exist))){
                    array_push($tags_exist,$i);
                }
            }
        }
        return view('pages.admin.image.edit')->with('country',$data)->with('languages', LanguageType::lists())->with("tags_exist",$tags_exist);
    }

    public function update(Request $req, $id) {
        $data = ImageModel::findOrFail($id);

        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'language' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,webp'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
            'language.required' => 'Please enter the language !',
            'language.regex' => 'Please enter the valid language !',
            'image.image' => 'Please enter a valid image !',
            'image.mimes' => 'Please enter a valid image !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data->title = $req->title;
        $data->year = $req->year;
        $data->deity = $req->deity;
        $data->tags = $req->tags;
        $data->version = $req->version;
        $data->language = $req->language;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();
            
            if($data->image!=null){
                unlink(public_path('upload/images/'.$data->image)); 
                unlink(public_path('upload/images/compressed-'.$data->image)); 
            }

            $img = Image::make($req->file('image')->getRealPath());
            $img->resize(300, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('upload/images').'/'.'compressed-'.$newImage);

            $req->image->move(public_path('upload/images'), $newImage);
            $data->image = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('image_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function delete($id){
        $data = ImageModel::findOrFail($id);
        if($data->image!=null){
            unlink(public_path('upload/images/'.$data->image)); 
            unlink(public_path('upload/images/compressed-'.$data->image)); 
        }
        $data->delete();
        return redirect()->intended(route('image_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = ImageModel::where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%')
            ->orWhere('language', LanguageType::getStatusId($search))
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = ImageModel::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.image.list')->with('country', $data)->with('languages', LanguageType::lists());
    }

    public function display($id) {
        $data = ImageModel::findOrFail($id);
        return view('pages.admin.image.display')->with('country',$data)->with('languages', LanguageType::lists());
    }

    public function excel(){
        return Excel::download(new ImageExport, 'image.xlsx');
    }



}