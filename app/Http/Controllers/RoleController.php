<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Common\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('Role');
        $data['sub_title'] = __('list');
        if($request->ajax()){
            $search_params['data_table'] = true;
            return (new Role())->getAllData($search_params)->getData();
        }
        return view('super_admin.role.index', $data);
    }
    public function add(Request $request)
    {
        $data['title'] = __('Role');
        $data['sub_title'] = __('Add');
        if($request->isMethod('POST')){
            list($status_code, $status_message, $label) = (new RoleService())->addRole($request->all());
            flash(__($status_message))->$label();
            return redirect()->back()->withInput();
        }
        return view('super_admin.role.add', $data);
    }
    public function edit($id)
    {
        $data['title'] = __('Role');
        $data['sub_title'] = __('edit');
        $data['role'] = (new Role())->getById($id);
        return view('super_admin.role.edit', $data);
    }
    public function update(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new RoleService())->updateRole($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function delete($id)
    {
        list($status_code, $status_message, $label) = (new RoleService())->deleteRole($id);
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
