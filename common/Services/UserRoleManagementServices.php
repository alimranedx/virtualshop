<?php

namespace Common\Services;

use App\Models\Menu;
use App\Models\Role;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserRoleManagement;
use Carbon\Carbon;
use Common\Exception\Exception;
use Common\Http\StatusService;
use Common\Logging\ManageLogging;
use Common\Services\Validation\CustomRequestValidation;
use Illuminate\Support\Facades\DB;

class UserRoleManagementServices
{
    public function index()
    {
        $data['title'] = __('User Role Management');
        $data['sub_title'] = __('list');
        $data['userData'] = (new User())->getAllUsers(['user_type' => User::USER_TYPE_ADMIN]);
        $data['roleData'] = (new Role())->getAllData();
        return $data;
    }
    public function save($input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            DB::beginTransaction();
            list($status_code, $status_description) = CustomRequestValidation::validateUserRoleSaveRules($input);
            if (empty($status_code)) {
                $prepare_data = $this->prepareData($input);
                if (!empty($prepare_data)) {
                    $userRoleManagementObj = new UserRoleManagement();
                    $userRoleManagementObj->deleteByRoleId($input['role']);
                    $create_status = $userRoleManagementObj->insertData($prepare_data);
                    if ($create_status) {
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Added SubMenu!';
                    }
                    DB::commit();
                }
            } else {
                $label = StatusService::LABEL_DANGER;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $log_data['action'] = 'PERMISSION_ADD';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
    public function prepareData($input)
    {
        $data = [];
        if(!empty($input['role']) && !empty($input['users'])){
            $role = $input['role'];
            foreach ($input['users'] as $user){
                $data[] = [
                    'role_id' => $role,
                    'user_id' => $user,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        }
        return $data;
    }
    public function getUserIdsByRole($role_id)
    {
        $user_ids = [];
        $userRoleManagementData = (new UserRoleManagement())->getByRoleId($role_id);
        if(!empty($userRoleManagementData)){
            $user_ids = $userRoleManagementData->pluck('user_id')->toArray();
        }
        return $user_ids;
    }
    public function updateSubMenu($id, $input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getSubMenuUpdateRules($id));
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $update_status = (new SubMenu())->updateById($id, $prepare_data);
                    if($update_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Updated SubMenu!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'PERMISSION_UPDATE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
    public function deleteSubMenu($id)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            if(!empty($id)){
                $delete_status = (new SubMenu())->deleteById($id);
                if($delete_status){
                    $status_code = StatusService::SUCCESS;
                    $label = StatusService::LABEL_SUCCESS;
                    $status_description = 'Successfully SubMenu deleted!';
                }
            }else{
                $status_code = StatusService::EXCEPTION;
                $status_description = 'SubMenu id is empty';
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'PERMISSION_DELETE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
    public function getEditData($id, $data){
        $data['subMenu'] = (new SubMenu())->getById($id);
        $data['menu'] = (new menu())->getAll();
        return $data;
    }
}
