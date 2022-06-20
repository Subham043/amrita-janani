<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;

class DashboardController extends Controller
{
    public function __construct()
    {
       //parent::__construct();

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function index(){
        return view('pages.admin.dashboard.index');
    }

}
