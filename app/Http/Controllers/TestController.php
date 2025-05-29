<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index4()
    {
        return view('layouts.app_copy');
    }
}
