<?php

namespace Common\Services;

use App\Models\Menu;
use App\Models\SubMenu;
use Common\Exception\Exception;
use Common\Http\StatusService;
use Common\Logging\ManageLogging;
use Common\Services\Validation\CustomRequestValidation;

class SubMenuService
{
    public function addSubMenu($input, $data, $is_post_method = false)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            if($is_post_method){
                list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getSubMenuAddRules());
                if(empty($status_code)){
                    $prepare_data = $this->prepareData($input);
                    if(!empty($prepare_data)){
                        $create_status = (new SubMenu())->createSubMenu($prepare_data);
                        if($create_status){
                            $status_code = StatusService::SUCCESS;
                            $label = StatusService::LABEL_SUCCESS;
                            $status_description = 'Successfully Added SubMenu!';
                        }
                    }
                }else{
                    $label = StatusService::LABEL_DANGER;
                }
            }else{
                $data['menu'] = (new Menu())->getAll();
            }

        }catch(\Throwable $th){
            $log_data['action'] = 'PERMISSION_ADD';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label, $data];
    }
    public function prepareData($input)
    {
        $data = [];
        if(!empty($input['menu_id'])){
            $data['menu_id'] = $input['menu_id'];
        }
        if(!empty($input['name'])){
            $data['name'] = $input['name'];
        }
        if(!empty($input['display_name'])){
            $data['display_name'] = $input['display_name'];
        }
        if(!empty($input['controller_name'])){
            $data['controller_name'] = $input['controller_name'];
        }
        if(!empty($input['method_name'])){
            $data['method_name'] = $input['method_name'];
        }
        if(!empty($input['order'])){
            $data['order'] = $input['order'];
        }
        if(!empty($input['icon'])){
            $data['icon'] = $input['icon'];
        }
        return $data;
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
