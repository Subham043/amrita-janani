<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class RegisterPageController extends Controller
{
    public function index(){
        return view('pages.main.register')->with('breadcrumb','Sign Up');
    }
}
