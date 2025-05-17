<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('manager.dashboard');
        }else{
            return redirect()->route('manager.login');
        }
    }
    public function dashboard()
    {
        return view('dashboard.manager');
    }
}
