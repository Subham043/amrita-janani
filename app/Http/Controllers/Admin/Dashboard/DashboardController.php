<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\ImageModel;
use App\Models\AudioModel;
use App\Models\DocumentModel;
use App\Models\VideoModel;

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
        return view('pages.admin.dashboard.index')->with('user_count',User::count())->with('enquiry_count',Enquiry::count())->with('media_count',ImageModel::count()+AudioModel::count()+DocumentModel::count()+VideoModel::count());
    }

}
