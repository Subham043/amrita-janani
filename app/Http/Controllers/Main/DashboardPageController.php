<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardPageController extends Controller
{
    public function index(){
        return view('pages.main.content.dashboard')->with('breadcrumb','Dashboard');
    }
}