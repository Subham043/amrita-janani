<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\AudioModel;
use App\Models\ImageModel;
use App\Models\DocumentModel;
use App\Models\VideoModel;
use App\Models\SearchHistory;

class DashboardPageController extends Controller
{
    public function index(Request $request){
        $images = ImageModel::where('status', 1);
        $audios = AudioModel::where('status', 1);
        $videos = VideoModel::where('status', 1);
        $documents = DocumentModel::where('status', 1);

        if($request->has('search')){
            $search  = $request->input('search');
            $audios->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
            
            $images->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
            
            $documents->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');
            
            $videos->where('title', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('deity', 'like', '%' . $search . '%')
            ->orWhere('version', 'like', '%' . $search . '%')
            ->orWhere('tags', 'like', '%' . $search . '%')
            ->orWhere('description_unformatted', 'like', '%' . $search . '%')
            ->orWhere('uuid', 'like', '%' . $search . '%');

            $searchHistory = new SearchHistory;
            $searchHistory->search = $search;
            $searchHistory->user_id = Auth::user()->id;
            $searchHistory->screen = 1;
            $searchHistory->save();
        }

        $images = $images->take(8)->orderBy('id', 'DESC')->get();
        $audios = $audios->take(8)->orderBy('id', 'DESC')->get();
        $videos = $videos->take(8)->orderBy('id', 'DESC')->get();
        $documents = $documents->take(8)->orderBy('id', 'DESC')->get();

        return view('pages.main.content.dashboard')
        ->with('breadcrumb','Dashboard')
        ->with('images', $images)
        ->with('audios', $audios)
        ->with('videos', $videos)
        ->with('documents', $documents);
    }
    
    public function search_query(Request $request){

        $search  = $request->phrase;
        $data = [];
        $audios = AudioModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($audios as $value) {
            if(!in_array(array("name"=>$value->title, "group"=>"Audios"), $data)){
                array_push($data,array("name"=>$value->title, "group"=>"Audios"));
            }
        }

        $tags = AudioModel::select('tags')->whereNotNull('tags')->where('tags', 'like', '%' . $search . '%')->get();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array(array("name"=>$i, "group"=>"Tags"), $data))){
                    array_push($data,array("name"=>$i, "group"=>"Tags"));
                }
            }
        }
        
        $images = ImageModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($images as $value) {
            if(!in_array(array("name"=>$value->title, "group"=>"Images"), $data)){
                array_push($data,array("name"=>$value->title, "group"=>"Images"));
            }
        }

        $tags = ImageModel::select('tags')->whereNotNull('tags')->where('tags', 'like', '%' . $search . '%')->get();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array(array("name"=>$i, "group"=>"Tags"), $data))){
                    array_push($data,array("name"=>$i, "group"=>"Tags"));
                }
            }
        }
        
        $documents = DocumentModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($documents as $value) {
            if(!in_array(array("name"=>$value->title, "group"=>"Documents"), $data)){
                array_push($data,array("name"=>$value->title, "group"=>"Documents"));
            }
        }

        $tags = DocumentModel::select('tags')->whereNotNull('tags')->where('tags', 'like', '%' . $search . '%')->get();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array(array("name"=>$i, "group"=>"Tags"), $data))){
                    array_push($data,array("name"=>$i, "group"=>"Tags"));
                }
            }
        }
        
        $videos = VideoModel::where('status', 1)->where('title', 'like', '%' . $search . '%')
        ->orWhere('year', 'like', '%' . $search . '%')
        ->orWhere('deity', 'like', '%' . $search . '%')
        ->orWhere('version', 'like', '%' . $search . '%')
        ->orWhere('tags', 'like', '%' . $search . '%')
        ->orWhere('description_unformatted', 'like', '%' . $search . '%')
        ->orWhere('uuid', 'like', '%' . $search . '%')
        ->get();

        foreach ($videos as $value) {
            if(!in_array(array("name"=>$value->title, "group"=>"Videos"), $data)){
                array_push($data,array("name"=>$value->title, "group"=>"Videos"));
            }
        }

        $tags = VideoModel::select('tags')->whereNotNull('tags')->where('tags', 'like', '%' . $search . '%')->get();
        foreach ($tags as $tag) {
            $arr = explode(",",$tag->tags);
            foreach ($arr as $i) {
                if (!(in_array(array("name"=>$i, "group"=>"Tags"), $data))){
                    array_push($data,array("name"=>$i, "group"=>"Tags"));
                }
            }
        }
        
        $searchHistory = SearchHistory::where('screen', 1)->where('search', 'like', '%' . $search . '%')->get();

        foreach ($searchHistory as $value) {
            if(!in_array(array("name"=>$value->search, "group"=>"Audios"), $data) && !in_array(array("name"=>$value->search, "group"=>"Images"), $data) && !in_array(array("name"=>$value->search, "group"=>"Videos"), $data) && !in_array(array("name"=>$value->search, "group"=>"Documents"), $data) && !in_array(array("name"=>$value->search, "group"=>"Tags"), $data)){
                array_push($data,array("name"=>$value->search, "group"=>"Previous Searches"));
            }
        }


        return response()->json(["data"=>$data], 200);
    }
}
