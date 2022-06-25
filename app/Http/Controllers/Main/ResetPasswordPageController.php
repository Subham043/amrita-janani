<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ResetPasswordPageController extends Controller
{
    public function index(){
        return view('pages.main.reset_password')->with('breadcrumb','Reset Password');
    }
}
