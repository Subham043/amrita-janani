<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaptchaController extends Controller
{

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
    
}