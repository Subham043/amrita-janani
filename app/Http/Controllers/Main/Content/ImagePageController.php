<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ImagePageController extends Controller
{
    public function index(){
        return view('pages.main.content.image')->with('breadcrumb','Images');
    }
}