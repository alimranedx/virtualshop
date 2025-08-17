<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Common\Services\RolePageService;
use Illuminate\Http\Request;

class RolePageController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('Role Page');
        $data['sub_title'] = __('list');
        $data += (new RolePageService())->index();
        if ($request->ajax()) {

        }
        return view('super_admin.role_page.index', $data);
    }

}
