<?php

namespace App\Http\Controllers;

use App\Models\User;
use Common\Services\UserService;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('User Management');
        $data['sub_title'] = __('list');
        if($request->ajax()){
            $search_params['user_type'] = [User::USER_TYPE_ADMIN, User::USER_TYPE_MANAGER, User::USER_TYPE_USER];
            $search_params['data_table'] = true;
            return (new User())->getAllUsers($search_params)->getData();
        }
        return view('super_admin.user_management.index', $data);
    }
    public function userEdit($id)
    {
        $data['title'] = __('User Management');
        $data['sub_title'] = __('edit');
        $data['user'] = (new User())->getById($id);
        $data['user_status'] = User::USER_STATUS;
        return view('super_admin.user_management.edit', $data);
    }
    public function userUpdate(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new UserService())->updateUser($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
