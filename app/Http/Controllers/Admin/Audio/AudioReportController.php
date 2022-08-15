<?php

namespace App\Http\Controllers\Admin\Audio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use URL;
use Illuminate\Support\Facades\View;
use App\Models\AudioReport;
use App\Models\AudioModel;
use App\Support\Types\UserType;
use Illuminate\Support\Facades\Validator;

class AudioReportController extends Controller
{
    public function __construct()
    {

       View::share('common', [
         'user_type' => UserType::lists()
        ]);
    }

    public function viewreport(Request $request) {
        if ($request->has('search') || $request->has('filter')) {
            $data = AudioReport::with(['AudioModel','User']);
            $data->whereHas('AudioModel', function($q) {
                $q->whereNull('deleted_at');
            })
            ->whereHas('User', function($q) {
                $q->whereNull('deleted_at');
            });
            if ($request->has('filter') && $request->input('filter')!='all') {
                $filter = $request->input('filter');
                $data->where('status',$filter);
            }
            if ($request->has('search')) {
                $search = $request->input('search');
                $data->whereHas('AudioModel', function($q)  use ($search){
                    $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', '%' . $search . '%');
                });
                $data->orWhereHas('User', function($q)  use ($search){
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            
            $data = $data->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
            $data = AudioReport::with(['AudioModel','User'])
            ->whereHas('AudioModel', function($q) {
                $q->whereNull('deleted_at');
            })
            ->whereHas('User', function($q) {
                $q->whereNull('deleted_at');
            })
            ->orderBy('id', 'DESC')->paginate(10);
        }
        return view('pages.admin.audio.report_list')
        ->with('country', $data);
    }

    public function deleteReport($id){
        $data = AudioReport::with(['AudioModel','User'])
        ->whereHas('AudioModel', function($q) {
            $q->whereNull('deleted_at');
        })
        ->whereHas('User', function($q) {
            $q->whereNull('deleted_at');
        })
        ->findOrFail($id);
        $data->forceDelete();
        return redirect()->intended(route('audio_view_report'))->with('success_status', 'Data Deleted successfully.');
    }

    public function toggleReport($id, Request $request){
        if ($request->has('status')) {
        $data = AudioReport::with(['AudioModel','User'])
        ->whereHas('AudioModel', function($q) {
            $q->whereNull('deleted_at');
        })
        ->whereHas('User', function($q) {
            $q->whereNull('deleted_at');
        })
        ->findOrFail($id);
        switch ($request->input('status')) {
            case '0':
            case '1':
            case '2':
                # code...
                $data->status = $request->input('status');
                $data->admin_id = Auth::user()->id;
                $data->save();
                return redirect()->intended(URL::previous())->with('success_status', 'Status updated successfully.');
                break;
            
            default:
                # code...
                return redirect()->intended(URL::previous())->with('error_status', 'Invalid status found.');
                break;
        }
    }else{
        return redirect()->intended(URL::previous())->with('error_status', 'No status found.');
    }

    }

    public function displayReport($id) {
        $data = AudioReport::with(['AudioModel','User'])
        ->whereHas('AudioModel', function($q) {
            $q->whereNull('deleted_at');
        })
        ->whereHas('User', function($q) {
            $q->whereNull('deleted_at');
        })
        ->findOrFail($id);
        return view('pages.admin.audio.report_display')->with('country',$data);
    }
    



}