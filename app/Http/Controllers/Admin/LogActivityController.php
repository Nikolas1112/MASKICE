<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use App\Repositories\Interfaces\Admin\DashboardInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{

    public function index(Request $request){
        try{
            // Retrieve all log activities and eager load related user data
            $logActivityData = LogActivity::with('user')
                ->orderBy('created_at', 'desc') // Order by created_at in descending order
                ->paginate(10); // Paginate with 10 records per page
            return view('admin.log_activity.index',compact('logActivityData'));
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

}