<?php

namespace App\Http\Controllers\Admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Models\VideoAccess;
use App\Models\VideoModel;
use App\Support\Types\UserType;
use Illuminate\Support\Facades\Validator;

class VideoAccessController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function viewaccess(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $data = VideoAccess::with(['VideoModel','User'])
            ->whereHas('VideoModel', function($q) {
                $q->whereNull('deleted_at');
            })
            ->whereHas('User', function($q) {
                $q->whereNull('deleted_at');
            })
            ->orWhereHas('VideoModel', function($q)  use ($search){
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('uuid', 'like', '%' . $search . '%');
            })
            ->orWhereHas('User', function($q)  use ($search){
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = VideoAccess::with(['VideoModel','User'])
            ->whereHas('VideoModel', function($q) {
                $q->whereNull('deleted_at');
            })
            ->whereHas('User', function($q) {
                $q->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.video.access_list')
        ->with('country', $data);
    }

    public function deleteAccess($id){
        $data = VideoAccess::with(['VideoModel','User'])
        ->whereHas('VideoModel', function($q) {
            $q->whereNull('deleted_at');
        })
        ->whereHas('User', function($q) {
            $q->whereNull('deleted_at');
        })
        ->findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(route('video_view_access'))->with('success_status', 'Data Deleted successfully.');
    }

    public function toggleAccess($id){
        $data = VideoAccess::with(['VideoModel','User'])
        ->whereHas('VideoModel', function($q) {
            $q->whereNull('deleted_at');
        })
        ->whereHas('User', function($q) {
            $q->whereNull('deleted_at');
        })
        ->findOrFail($id);
        if($data->status == '1'){
            $data->status = 0;
            $data->admin_id = Auth::user()->id;
            $data->save();
            return redirect()->intended(URL::previous())->with('success_status', 'Access revoked successfully.');
        }else{
            $data->status = 1;
            $data->admin_id = Auth::user()->id;
            $data->save();
            return redirect()->intended(URL::previous())->with('success_status', 'Access granted successfully.');
        }
    }

    public function displayAccess($id) {
        $data = VideoAccess::findOrFail($id);
        return view('pages.admin.video.access_display')->with('country',$data);
    }
    



}