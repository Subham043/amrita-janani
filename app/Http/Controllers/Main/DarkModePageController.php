<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use App\Models\User;

class DarkModePageController extends Controller
{
    public function index(){
        $user = User::where('id',Auth::user()->id)->firstOrFail();
        if($user->darkMode == 0){
            $user->darkmode = 1;
            $user->save();
            return redirect(URL::previous());
        }else{
            $user->darkmode =  0;
            $user->save();
            return redirect(URL::previous());
        }
    }
}