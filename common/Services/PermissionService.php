<?php

namespace Common\Services;

use App\Models\Permission;
use Common\Exception\Exception;
use Common\Http\StatusService;
use Common\Logging\ManageLogging;
use Common\Services\Validation\CustomRequestValidation;

class PermissionService
{
    public function addPermission($input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getPermissionAddRules());
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $create_status = (new Permission())->createPermission($prepare_data);
                    if($create_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Added Permission!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
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
        if(!empty($input['name'])){
            $data['name'] = $input['name'];
        }
        if(!empty($input['display_name'])){
            $data['display_name'] = $input['display_name'];
        }
        if(isset($input['type'])){
            $data['type'] = $input['type'];
        }
        return $data;
    }
    public function updatePermission($id, $input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getPermissionUpdateRules($id));
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $update_status = (new Permission())->updateById($id, $prepare_data);
                    if($update_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Updated Permission!';
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
    public function deletePermission($id)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            if(!empty($id)){
                $delete_status = (new Permission())->deleteById($id);
                if($delete_status){
                    $status_code = StatusService::SUCCESS;
                    $label = StatusService::LABEL_SUCCESS;
                    $status_description = 'Successfully Permission deleted!';
                }
            }else{
                $status_code = StatusService::EXCEPTION;
                $status_description = 'Permission id is empty';
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
}
