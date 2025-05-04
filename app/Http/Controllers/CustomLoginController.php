<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomLoginController extends Controller
{
    public function superAdminLogin()
    {
        return view('custom_login.super_admin_login');
    }
    public function adminLogin()
    {
        return view('custom_login.admin_login');
    }
    public function managerLogin()
    {
        return view('custom_login.manager_login');
    }
}
