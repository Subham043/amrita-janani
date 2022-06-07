<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ResetPasswordController extends Controller
{
    public function index(){
        return view('pages.admin.auth.resetpassword');
    }
}
