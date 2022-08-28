<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Uuid;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\PageModel;
use App\Models\PageContentModel;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function home_page(){
        return view('pages.admin.page_content.home')->with('page_detail', PageModel::find(1))->with('page_content_detail', PageContentModel::where('page_id',1)->get())->with('page_name', 'Home');
    }
    
    public function about_page(){
        return view('pages.admin.page_content.home')->with('page_detail', PageModel::find(2))->with('page_content_detail', PageContentModel::where('page_id',2)->get())->with('page_name', 'About');
    }
    
    public function edit_dynamic_page($id){
        $page_detail = PageModel::findOrFail($id);
        $page_content_detail = PageContentModel::where('page_id',$id)->get();
        return view('pages.admin.page_content.edit')->with('page_detail', $page_detail)->with('page_content_detail', $page_content_detail)->with('page_name', $page_detail->page_name);
    }

    public function getPageContent(Request $req){
        $rules = array(
            'id' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'id.required' => 'Please enter the id !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }
        return response()->json(['data'=>PageContentModel::findOrFail($req->id)], 200);
    }
    
    public function dynamic_page_list(Request $request){
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $data = PageModel::where('id', '!=',1)->where('id', '!=',2)->where('title', 'like', '%' . $search . '%')
            ->orWhere('page_name', 'like', '%' . $search . '%')
            ->orWhere('url', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC');
            $data = $data->paginate(10);
        }else{
            $data = PageModel::where('id', '!=',1)->where('id', '!=',2)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.page_content.list')->with('country', $data);
    }

    public function storePage(Request $req){

        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'page_name' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i','unique:pages'],
            'url' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i','unique:pages'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'url.required' => 'Please enter the url !',
            'url.regex' => 'Please enter the valid url !',
            'url.unique' => 'This url is already taken!',
            'page_name.unique' => 'This page name is already taken!',
            'page_name.required' => 'Please enter the page name !',
            'page_name.regex' => 'Please enter the valid page name !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new PageModel;
        $data->title = $req->title;
        $data->page_name = $req->page_name;
        $data->url = $req->url;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?route('edit_dynamic_page', $data->id):$req->refreshUrl, "message" => "Data updated successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }
    
    public function updatePage(Request $req, $id){
        $data = PageModel::findOrFail($id);

        $rules = array(
            'title' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'page_name' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
            'url' => ['nullable','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        );
        $messages = array(
            'title.required' => 'Please enter the title !',
            'title.regex' => 'Please enter the valid title !',
            'url.required' => 'Please enter the url !',
            'url.regex' => 'Please enter the valid url !',
            'url.unique' => 'This url is already taken!',
            'page_name.unique' => 'This page name is already taken!',
            'page_name.required' => 'Please enter the page name !',
            'page_name.regex' => 'Please enter the valid page name !',
        );

        if($data->page_name!==$req->page_name){
            $rules['page_name'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i','unique:pages'];
        }
        if($data->url!==$req->url){
            $rules['url'] = ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i','unique:pages'];
        }

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data->title = $req->title;
        $data->page_name = $req->page_name;
        $data->url = $req->url;

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?URL::previous():$req->refreshUrl, "message" => "Data updated successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function deletePage($id){
        $data = PageModel::where('id', '!=',1)->where('id', '!=',2)->findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(URL::previous())->with('success_status', 'Data Deleted permanently.');
    }

    public function storePageContent(Request $req) {
        $rules = array(
            'heading' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\?\'\r\n+=,]+$/i'],
            'description_unformatted' => ['required'],
            'page_id' => ['required'],
            'image' => ['nullable','mimes:jpg,jpeg,png,webp'],
        );
        $messages = array(
            'heading.required' => 'Please enter the heading !',
            'heading.regex' => 'Please enter the valid heading !',
            'description_unformatted.required' => 'Please enter the description !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }

        $data = new PageContentModel;
        $data->heading = $req->heading;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->page_id = $req->page_id;

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();
            

            $req->image->storeAs('public/upload/pages',$newImage);
            $data->image = $newImage;
            $data->image_position = $req->image_position;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?URL::previous():$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }
    
    public function updatePageContent(Request $req) {
        $rules = array(
            'heading' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\?\'\r\n+=,]+$/i'],
            'description_unformatted' => ['required'],
            'id' => ['required'],
            'page_id' => ['required'],
            'image' => ['nullable','mimes:jpg,jpeg,png,webp'],
        );
        $messages = array(
            'heading.required' => 'Please enter the heading !',
            'heading.regex' => 'Please enter the valid heading !',
            'description_unformatted.required' => 'Please enter the description !',
        );
        
        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["form_error"=>$validator->errors()], 400);
        }
        
        $data = PageContentModel::findOrFail($req->id);
        $data->heading = $req->heading;
        $data->description = $req->description;
        $data->description_unformatted = $req->description_unformatted;
        $data->page_id = $req->page_id;
        $data->image_position = $req->image_position;

        if($req->hasFile('image')){
            $uuid = Uuid::generate(4)->string;
            $newImage = $uuid.'-'.$req->image->getClientOriginalName();

            if($data->image!=null && file_exists(storage_path('app/public/upload/pages').'/'.$data->image)){
                unlink(storage_path('app/public/upload/pages/'.$data->image)); 
            }
            

            $req->image->storeAs('public/upload/pages',$newImage);
            $data->image = $newImage;
        }

        $result = $data->save();
        
        if($result){
            return response()->json(["url"=>empty($req->refreshUrl)?URL::previous():$req->refreshUrl, "message" => "Data Stored successfully.", "data" => $data], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function deletePageContent($id){
        $data = PageContentModel::findOrFail($id);
        if($data->image!=null && file_exists(storage_path('app/public/upload/pages').'/'.$data->image)){
            unlink(storage_path('app/public/upload/pages/'.$data->image)); 
        }
        $data->forceDelete();
        return redirect()->intended(URL::previous())->with('success_status', 'Data Deleted permanently.');
    }
}