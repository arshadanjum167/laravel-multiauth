<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('comming gherte');
        $user_count = User::where(['is_deleted'=>'N','is_active'=>'Y'])->where('isAdmin','<>','1')->count();
        
        return view('dashboard',[
            'user_count'=>$user_count
                                 ]);
    }
}
