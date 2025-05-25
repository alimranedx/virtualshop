<?php

namespace Common\Services;

use App\Models\User;
use Common\Exception\Exception;
use Common\Http\StatusService;
use Common\Logging\ManageLogging;
use Common\Services\Validation\CustomRequestValidation;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function updateUser($id, $input)
    {
        $status_code = '';
        $label = '';
        $status_description = '';
        try {
            list($status_code, $status_description) = CustomRequestValidation::validateData($input, CustomRequestValidation::getUserManagementUpdateRules());
            if(empty($status_code)){
                $prepare_data = $this->prepareUserUpdateData($input);
                if(!empty($prepare_data)){
                    $update_status = (new User())->updateUserById($id, $prepare_data);
                    if($update_status){
                        $status_code = StatusService::SUCCESS;
                        $label = StatusService::LABEL_SUCCESS;
                        $status_description = 'Successfully User Updated!';
                    }
                }
            }else{
                $label = StatusService::LABEL_DANGER;
            }
        }catch(\Throwable $th){
            $log_data['action'] = 'USER_MANAGEMENT_UPDATE';
            $log_data['error_message'] = Exception::getFullMessage($th);
            ManageLogging::createLog($log_data);
            $status_code = StatusService::EXCEPTION;
            $label = StatusService::LABEL_DANGER;
            $status_description = StatusService::CUSTOM_EXCEPTION_MESSAGE;

        }
        return [$status_code, $status_description, $label];
    }
    public function prepareUserUpdateData($input)
    {
        $data = [];
        if(!empty($input['name'])){
            $data['name'] = $input['name'];
        }
        if(isset($input['status'])){
            $data['status'] = $input['status'];
        }
        return $data;
    }
}
