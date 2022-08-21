<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PrivacyPolicyPageController extends Controller
{
    public function index(){
        return view('pages.main.privacy_policy')->with('breadcrumb','Privacy Policy');
    }
}
