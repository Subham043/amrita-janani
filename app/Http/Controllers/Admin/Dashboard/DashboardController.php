<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index(){
        // if (!Auth::check()) {
        //     return redirect('admin/dashboard');
        // }
        return view('pages.admin.dashboard.index');
    }

}
