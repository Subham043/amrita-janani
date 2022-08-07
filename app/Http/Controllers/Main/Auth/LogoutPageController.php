<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LogoutPageController extends Controller
{
    public function logout() {
        Auth::logout();
  
        return redirect(route('index'));
    }
}