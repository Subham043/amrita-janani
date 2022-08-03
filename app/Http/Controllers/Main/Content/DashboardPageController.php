<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardPageController extends Controller
{
    public function index(){
        return view('pages.main.content.dashboard')->with('breadcrumb','Dashboard');
    }
}