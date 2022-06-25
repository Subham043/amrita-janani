<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ForgotPasswordPageController extends Controller
{
    public function index(){
        return view('pages.main.forgot_password')->with('breadcrumb','Forgot Password');
    }
}
