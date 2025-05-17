<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('super.admin.dashboard');
        }else{
            return redirect()->route('super.admin.login');
        }
    }
    public function dashboard()
    {
        return view('dashboard.superadmin');
    }
}
