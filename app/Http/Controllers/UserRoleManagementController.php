<?php

namespace App\Http\Controllers;

use App\Models\SubMenu;
use App\Models\UserRoleManagement;
use Common\Services\UserRoleManagementServices;
use Illuminate\Http\Request;

class UserRoleManagementController extends Controller
{
    public function index(Request $request)
    {
        $userRoleManagementServicesObj = new UserRoleManagementServices();
        $userRoleManagementObj = new UserRoleManagement();
        $data = $userRoleManagementServicesObj->index();
        if($request->ajax()){
            if(!empty($request->action) && $request->action == 'get_role_wise_users' && !empty($request->role_id)){
                $user_ids = $userRoleManagementServicesObj->getUserIdsByRole($request->role_id);
                return ['user_ids' => $user_ids];
            }
            $search_params['data_table'] = true;
            return $userRoleManagementObj->getAllData($search_params)->getData();
        }
        return view('super_admin.user_role_management.index', $data);
    }
    public function save(Request $request)
    {
        list($status_code, $status_message, $label) = (new UserRoleManagementServices())->save($request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function edit($id)
    {
        $data['title'] = __('SubMenu');
        $data['sub_title'] = __('edit');
        $data = (new UserRoleManagementServices())->getEditData($id,$data);
        return view('super_admin.user_role_management.edit', $data);
    }
    public function update(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new UserRoleManagementServices())->updateSubMenu($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function delete($id)
    {
        list($status_code, $status_message, $label) = (new UserRoleManagementServices())->deleteSubMenu($id);
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
