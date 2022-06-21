<?php

namespace App\Http\Controllers\Admin\Enquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
use App\Support\Types\UserType;
use App\Models\Enquiry;
use App\Exports\EnquiryExport;
use Maatwebsite\Excel\Facades\Excel;

class EnquiryController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function delete($id){
        $country = Enquiry::findOrFail($id);
        $country->delete();
        return redirect()->intended(route('enquiry_view'))->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $country = Enquiry::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('subject', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            })->paginate(10);
        }else{
            $country = Enquiry::orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.enquiry.list')->with('country', $country);
    }

    public function display($id) {
        $country = Enquiry::findOrFail($id);
        return view('pages.admin.enquiry.display')->with('country',$country);
    }

    public function excel(){
        return Excel::download(new EnquiryExport, 'enquiry.xlsx');
    }

}