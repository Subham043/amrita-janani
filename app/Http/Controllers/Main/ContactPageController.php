<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ContactPageController extends Controller
{
    public function index(){
        return view('pages.main.contact')->with('breadcrumb','Contact');
    }
}
