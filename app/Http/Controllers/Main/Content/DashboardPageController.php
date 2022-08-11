<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\AudioModel;
use App\Models\ImageModel;
use App\Models\DocumentModel;
use App\Models\VideoModel;

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
            array_push($data,array("name"=>$value->title));
            array_push($data,array("name"=>$value->uuid));
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
            array_push($data,array("name"=>$value->title));
            array_push($data,array("name"=>$value->uuid));
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
            array_push($data,array("name"=>$value->title));
            array_push($data,array("name"=>$value->uuid));
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
            array_push($data,array("name"=>$value->title));
            array_push($data,array("name"=>$value->uuid));
        }

        return $data;
    }
}
