<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQModel;
use Auth;

class FAQPageController extends Controller
{
    public function index(){
        return view('pages.main.faq')->with('breadcrumb','Frequently Asked Questions')->with('faq', FAQModel::all());
    }
}
