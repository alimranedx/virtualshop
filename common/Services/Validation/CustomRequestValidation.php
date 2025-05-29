<?php

namespace Common\Services\Validation;

use App\Models\Menu;
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
    public static function getPermissionAddRules()
    {
        return [
            'name' => ['required', 'min:2' , 'max:255', 'unique:permissions,name'],
            'display_name' => ['required', 'min:2' , 'max:255', 'unique:permissions,display_name'],
            'type' => ['required', Rule::in(User::USER_TYPES)]
        ];
    }
    public static function getPermissionUpdateRules($permission_id)
    {
        return [
            'name' => ['required', 'min:2' , 'max:255', Rule::unique('permissions', 'name')->ignore($permission_id)],
            'display_name' => ['required', 'min:2' , 'max:255', Rule::unique('permissions', 'display_name')->ignore($permission_id)],
            'type' => ['required', Rule::in(User::USER_TYPES)]
        ];
    }
    public static function getMenuAddRules()
    {
        return [
            'name' => ['required', 'string', 'min:2' , 'max:255', 'unique:menu,name'],
            'display_name' => ['required', 'string', 'min:2' , 'max:255', 'unique:menu,display_name'],
            'order' => ['required', 'integer', 'unique:menu,order'],
            'icon' => ['sometimes', 'string' ,'max:255'],
        ];
    }
    public static function getMenuUpdateRules($menu_id)
    {
        return [
            'name' => ['required', 'string', 'min:2' , 'max:255', Rule::unique('menu', 'name')->ignore($menu_id)],
            'display_name' => ['required', 'string', 'min:2' , 'max:255', Rule::unique('menu', 'display_name')->ignore($menu_id)],
            'order' => ['required', 'integer', Rule::unique('menu', 'order')->ignore($menu_id)],
            'icon' => ['sometimes', 'string', 'min:2' ,'max:255'],
        ];
    }

    public static function getSubMenuAddRules()
    {
        $menu_ids = (new Menu())->getAll()->pluck('id')->toArray() ?? [];

        return [
            'menu_id' => ['required', Rule::in($menu_ids)],
            'name' => ['required', 'string', 'min:2' , 'max:255', 'unique:sub_menu,name'],
            'display_name' => ['required', 'string', 'min:2' , 'max:255', 'unique:sub_menu,display_name'],
            'controller_name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                function ($attribute, $value, $fail) {
                    $fullClass = str_contains($value, '\\') ? $value : 'App\\Http\\Controllers\\' . $value;

                    if (!class_exists($fullClass)) {
                        $fail("The controller class '{$value}' does not exist.");
                    }
                }
            ],
            'method_name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                function ($attribute, $value, $fail) {
                    $controller = request()->input('controller_name');
                    $fullClass = str_contains($value, '\\') ? $value : 'App\\Http\\Controllers\\' . $controller;
                    if (class_exists($fullClass)) {
                        if (!method_exists(app($fullClass), $value)) {
                            $fail("The method '{$value}' does not exist in controller '{$controller}'.");
                        }
                    }
                }
            ],
            'order' => ['required', 'integer', 'unique:sub_menu,order'],
            'icon' => ['sometimes', 'string', 'max:255'],
        ];
    }

    public static function getSubMenuUpdateRules($sub_menu_id)
    {
        $menu_ids = (new Menu())->getAll()->pluck('id')->toArray() ?? [];
        return [
            'menu_id' => ['required', Rule::in($menu_ids)],
            'name' => ['required', 'string', 'min:2' , 'max:255', Rule::unique('sub_menu', 'name')->ignore($sub_menu_id)],
            'display_name' => ['required', 'string', 'min:2' , 'max:255', Rule::unique('sub_menu', 'display_name')->ignore($sub_menu_id)],
            'controller_name' => [
                'required',
                'string',
                'min:2' ,
                'max:255',
                function ($attribute, $value, $fail) {
                    $fullClass = str_contains($value, '\\') ? $value : 'App\\Http\\Controllers\\' . $value;

                    if (!class_exists($fullClass)) {
                        $fail("The controller class '{$value}' does not exist.");
                    }
                }
            ],
            'method_name' => [
                'required', 'string', 'min:2' , 'max:255',
                function ($attribute, $value, $fail) {
                    $controller = request()->input('controller_name');
                    $fullClass = str_contains($value, '\\') ? $value : 'App\\Http\\Controllers\\' . $controller;
                    if (class_exists($fullClass)) {
                        if (!method_exists(app($fullClass), $value)) {
                            $fail("The method '{$value}' does not exist in controller '{$controller}'.");
                        }
                    }
                }
            ],
            'order' => ['required', 'integer', Rule::unique('sub_menu', 'order')->ignore($sub_menu_id)],
            'icon' => ['sometimes', 'string', 'min:2' ,'max:255'],
        ];
    }

}
