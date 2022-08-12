<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
    // public function index()
    // {
    //     return view('admin.dashboard.dashboard');
    // }

    public function showDashboard()
    {
        // dd(Auth::user()->id);
        $user = DB::table('employee')
        ->leftJoin('company', 'company.id', '=', 'employee.company_id')
        ->select('employee.*', 'company.name as company_name')
        ->where('employee.id', Auth::user()->id)
        ->first();
        // dd($user);
        // $user = Auth::user()->getAttributes();
        return view('admin.dashboard.dashboard', ['user' => $user]);
    }

   
}
