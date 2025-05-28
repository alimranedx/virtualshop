<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Common\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('Permission');
        $data['sub_title'] = __('list');
        if($request->ajax()){
            $search_params['data_table'] = true;
            return (new Permission())->getAllData($search_params)->getData();
        }
        return view('super_admin.permission.index', $data);
    }
    public function add(Request $request)
    {
        $data['title'] = __('Permission');
        $data['sub_title'] = __('Add');
        if($request->isMethod('POST')){
            list($status_code, $status_message, $label) = (new PermissionService())->addPermission($request->all());
            flash(__($status_message))->$label();
            return redirect()->back()->withInput();
        }
        return view('super_admin.permission.add', $data);
    }
    public function edit($id)
    {
        $data['title'] = __('Permission');
        $data['sub_title'] = __('edit');
        $data['permission'] = (new Permission())->getById($id);
        return view('super_admin.permission.edit', $data);
    }
    public function update(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new PermissionService())->updatePermission($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function delete($id)
    {
        list($status_code, $status_message, $label) = (new PermissionService())->deletePermission($id);
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
