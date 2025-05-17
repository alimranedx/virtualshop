<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisteredAdminController extends Controller
{
    public function create()
    {
        return view('auth.admin.register');
    }
}
