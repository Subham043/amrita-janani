<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginPageController extends Controller
{
    public function index(){
        return view('pages.main.login')->with('breadcrumb','Sign In');
    }
}
