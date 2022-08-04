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
    public function index(){
        return view('pages.main.content.dashboard')
        ->with('breadcrumb','Dashboard')
        ->with('images', ImageModel::where('status', 1)->take(8)->orderBy('id', 'DESC')->get())
        ->with('audios', AudioModel::where('status', 1)->take(8)->orderBy('id', 'DESC')->get())
        ->with('videos', VideoModel::where('status', 1)->take(8)->orderBy('id', 'DESC')->get())
        ->with('documents', DocumentModel::where('status', 1)->take(8)->orderBy('id', 'DESC')->get());
    }
}