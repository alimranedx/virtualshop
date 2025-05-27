<?php

namespace Common\Services\Validation;

use App\Models\User;
use Common\Http\StatusService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CustomRequestValidation
{
    public static function validateData($input, $rules, $messages = [])
    {
        $status_code = $error_message = '';
        $error_messages = [];
        $validator  = Validator::make($input, $rules, $messages);
        if($validator->fails()){
            $status_code = StatusService::BAD_REQUEST;
            $error_message = $validator->errors()->first();
            $error_messages = $validator->errors();
        }
        return [$status_code, $error_message, $error_messages];
    }
    public static function getUserManagementUpdateRules()
    {
        return [
            'name' => ['required', 'max:100'],
            'status' => ['required', Rule::in(array_keys(User::USER_STATUS))]
        ];
    }
    public static function getRoleAddRules()
    {
        return [
            'name' => ['required', 'min:2' , 'max:255', 'unique:roles,name'],
            'type' => ['required', Rule::in(User::USER_TYPES)]
        ];
    }
    public static function getRoleUpdateRules($role_id)
    {
        return [
            'name' => ['required', 'min:2' , 'max:255', Rule::unique('roles', 'name')->ignore($role_id)],
            'type' => ['required', Rule::in(User::USER_TYPES)]
        ];
    }

}
