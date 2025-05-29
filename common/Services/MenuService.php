<?php

namespace Common\Services;

use App\Models\Menu;
use Common\Exception\Exception;
use Common\Http\StatusService;
use Common\Logging\ManageLogging;
use Common\Services\Validation\CustomRequestValidation;

class MenuService
{
    public function addMenu($input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getMenuAddRules());
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $create_status = (new Menu())->createMenu($prepare_data);
                    if($create_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Added Menu!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'MENU_ADD';
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
        if(isset($input['order'])){
            $data['order'] = $input['order'];
        }
        if(isset($input['icon'])){
            $data['icon'] = $input['icon'];
        }
        return $data;
    }
    public function updateMenu($id, $input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getMenuUpdateRules($id));
            if(empty($status_code)){
                $prepare_data = $this->prepareData($input);
                if(!empty($prepare_data)){
                    $update_status = (new Menu())->updateById($id, $prepare_data);
                    if($update_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully Updated Menu!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'MENU_UPDATE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
    public function deleteMenu($id)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            if(!empty($id)){
                $delete_status = (new Menu())->deleteById($id);
                if($delete_status){
                    $status_code = StatusService::SUCCESS;
                    $label = StatusService::LABEL_SUCCESS;
                    $status_description = 'Successfully Menu deleted!';
                }
            }else{
                $status_code = StatusService::EXCEPTION;
                $status_description = 'Menu id is empty';
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'MENU_DELETE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
}
