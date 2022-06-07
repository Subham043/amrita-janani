<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AboutPageController extends Controller
{
    public function index(){
        return view('pages.main.about')->with('breadcrumb','About');
    }
}
