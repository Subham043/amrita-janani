<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\PageModel;

class AboutPageController extends Controller
{
    public function index(){
        $data = PageModel::findOrFail(2);
        return view('pages.main.about')->with('breadcrumb',$data->title)->with('about', $data);
    }
}
