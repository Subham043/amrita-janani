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
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Storage;

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
        $topics = ImageModel::select('topics')->whereNotNull('topics')->get();
        $topics_exist = array();
        foreach ($topics as $topic) {
            $arr = explode(",",$topic->topics);
            foreach ($arr as $i) {
                if (!(in_array($i, $topics_exist))){
                    array_push($topics_exist,$i);
                }
            }
        }

        return view('pages.admin.image.create')->with("tags_exist",$tags_exist)->with("topics_exist",$topics_exist);
    }

    public function store(Request $req) {
        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'image' => ['required','image','mimes:jpeg,png,jpg,webp'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
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
        $data->topics = $req->topics;
        $data->version = $req->version;
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
            })->save(storage_path('app/public/upload/images').'/'.'compressed-'.$newImage);

            $req->image->storeAs('public/upload/images',$newImage);
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
        $topics = ImageModel::select('topics')->whereNotNull('topics')->get();
        $topics_exist = [];
        foreach ($topics as $topic) {
            $arr = explode(",",$topic->topics);
            foreach ($arr as $i) {
                if (!(in_array($i, $topics_exist))){
                    array_push($topics_exist,$i);
                }
            }
        }
        return view('pages.admin.image.edit')->with('country',$data)->with("tags_exist",$tags_exist)->with("topics_exist",$topics_exist);
    }

    public function update(Request $req, $id) {
        $data = ImageModel::findOrFail($id);

        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'deity' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'version' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'year' => ['nullable','regex:/^[0-9]*$/'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,webp'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'deity.regex' => 'Please enter the valid deity !',
            'version.regex' => 'Please enter the valid version !',
            'year.regex' => 'Please enter the valid year !',
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
        $data->topics = $req->topics;
        $data->version = $req->version;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->status = $req->status == "on" ? 1 : 0;
        $data->restricted = $req->restricted == "on" ? 1 : 0;
        $data->user_id = Auth::user()->id;

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();
            
            if($data->image!=null && file_exists(storage_path('app/public/upload/images').'/'.$data->image)){
                unlink(storage_path('app/public/upload/images/'.$data->image)); 
                unlink(storage_path('app/public/upload/images/compressed-'.$data->image)); 
            }

            $img = Image::make($req->file('image')->getRealPath());
            $img->resize(300, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/upload/images').'/'.'compressed-'.$newImage);

            $req->image->storeAs('public/upload/images',$newImage);
            $data->image = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('image_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function restoreTrash($id){
        $data = ImageModel::withTrashed()->whereNotNull('deleted_at')->findOrFail($id);
        $data->restore();
        return redirect()->intended(route('image_view_trash'))->with('success_status', 'Data Restored successfully.');
    }
    
    public function restoreAllTrash(){
        $data = ImageModel::withTrashed()->whereNotNull('deleted_at')->restore();
        return redirect()->intended(route('image_view_trash'))->with('success_status', 'Data Restored successfully.');
    }

    public function delete($id){
        $data = ImageModel::findOrFail($id);
        $data->delete();
        return redirect()->intended(route('image_view'))->with('success_status', 'Data Deleted successfully.');
    }
    
    public function deleteTrash($id){
        $data = ImageModel::withTrashed()->whereNotNull('deleted_at')->findOrFail($id);
        if($data->image!=null && file_exists(storage_path('app/public/upload/images').'/'.$data->image)){
            unlink(storage_path('app/public/upload/images/'.$data->image)); 
            unlink(storage_path('app/public/upload/images/compressed-'.$data->image)); 
        }
        $data->forceDelete();
        return redirect()->intended(route('image_view_trash'))->with('success_status', 'Data Deleted permanently.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = ImageModel::where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = ImageModel::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.image.list')->with('country', $data);
    }
    
    public function viewTrash(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = ImageModel::withTrashed()->whereNotNull('deleted_at')->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = ImageModel::withTrashed()->whereNotNull('deleted_at')->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.image.list_trash')->with('country', $data);
    }

    public function display($id) {
        $data = ImageModel::findOrFail($id);
        $url = "";
        return view('pages.admin.image.display')->with('country',$data)->with('url',$url);
    }
    
    public function displayTrash($id) {
        $data = ImageModel::withTrashed()->whereNotNull('deleted_at')->findOrFail($id);
        $url = "";
        return view('pages.admin.image.display_trash')->with('country',$data)->with('url',$url);
    }

    public function excel(){
        return Excel::download(new ImageExport, 'image.xlsx');
    }

    public function bulk_upload(){
        return view('pages.admin.image.bulk_upload');
    }

    public function bulk_upload_store(Request $req) {
        $rules = array(
            'excel' => ['required','mimes:xls,xlsx'],
        );
        $messages = array(
            'excel.required' => 'Please select an excel !',
            'excel.mimes' => 'Please enter a valid excel !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $path = $req->file('excel')->getRealPath();
        $data = (new FastExcel)->import($path);

        if($data->count() == 0)
        {
            return response()->json(["form_error"=>"Please enter atleast one row of data in the excel."], 400);
        }elseif($data->count() > 30)
        {
            return response()->json(["form_error"=>"Maximum 30 rows of data in the excel are allowed."], 400);
        }else{
            foreach ($data as $key => $value) {
                if(file_exists(storage_path('app/public/zip/images').'/'.$value['image'])){

                    $exceldata = new ImageModel;
                    $exceldata->title = $value['title'];
                    $exceldata->description = $value['description'];
                    $exceldata->description_unformatted = $value['description'];
                    $exceldata->year = $value['year'];
                    $exceldata->deity = $value['deity'];
                    $exceldata->tags = $value['tags'];
                    $exceldata->topics = $value['topics'];
                    $exceldata->version = $value['version'];
                    $exceldata->status = 1;
                    $exceldata->user_id = Auth::user()->id;

                    switch ($value['restricted']) {
                        case 'true':
                        case 'True':
                        case 'TRUE':
                        case '1':
                        case 'restricted':
                            # code...
                            $exceldata->restricted = 1;
                            break;
                        
                        default:
                            # code...
                            $exceldata->restricted = 0;
                            break;
                    }

                    
                    $uuid = Uuid::generate(4)->string;
                    Storage::move('public/zip/images'.'/'.$value['image'], 'public/upload/images'.'/'.$uuid.'-'.$value['image']);
                    $exceldata->image = $uuid.'-'.$value['image'];
                    
                    
                    $img = Image::make(storage_path('app/public/upload/images').'/'.$uuid.'-'.$value['image']);
                    $img->resize(300, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/upload/images').'/'.'compressed-'.$uuid.'-'.$value['image']);

                    $result = $exceldata->save();
                }
                
                
                
            }
            return response()->json(["url"=>empty($req->refreshUrl)?route('image_view'):$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }

    }



}