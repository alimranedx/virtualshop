<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisteredManagerController extends Controller
{
    public function create()
    {
        return view('auth.manager.register');
    }
}
