<?php

namespace Common\Services;

use App\Models\Role;
use App\Models\User;
use Common\Exception\Exception;
use Common\Http\StatusService;
use Common\Logging\ManageLogging;
use Common\Services\Validation\CustomRequestValidation;

class RoleService
{
    public function addRole($input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getRoleAddRules());
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $create_status = (new Role())->createRole($prepare_data);
                    if($create_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Added Role!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'ROLE_ADD';
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
        if(!empty($input['name'])){
            $data['name'] = $input['name'];
        }
        if(isset($input['type'])){
            $data['type'] = $input['type'];
        }
        return $data;
    }
    public function updateRole($id, $input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getRoleUpdateRules($id));
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $update_status = (new Role())->updateById($id, $prepare_data);
                    if($update_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Updated Role!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'ROLE_UPDATE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
    public function deleteRole($id)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            if(!empty($id)){
                $delete_status = (new Role())->deleteById($id);
                if($delete_status){
                    $status_code = StatusService::SUCCESS;
                    $label = StatusService::LABEL_SUCCESS;
                    $status_description = 'Successfully Role deleted!';
                }
            }else{
                $status_code = StatusService::EXCEPTION;
                $status_description = 'Role id is empty';
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'ROLE_DELETE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
}
