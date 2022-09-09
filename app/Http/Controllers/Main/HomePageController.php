<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\PageModel;
use App\Models\BannerModel;
use App\Models\BannerQuoteModel;

class HomePageController extends Controller
{
    public function index(){
        $data = PageModel::findOrFail(1);
        return view('pages.main.index')->with('breadcrumb','Home')->with('home', $data)->with('bannerImage', BannerModel::inRandomOrder()->firstOrFail())->with('bannerQuote', BannerQuoteModel::inRandomOrder()->firstOrFail());
    }
}
