<?php
namespace Common\Services\Authentication;
use App\Models\User;

class UserDashboardControlService
{
    public function redirectToDashboard($authUser)
    {
        $redirect_to = 'dashboard';
        if(!empty($authUser->user_type)){
            if($authUser->user_type == User::USER_TYPE_SUPER_ADMIN){
                $redirect_to = 'super.admin.dashboard';
            }
            if($authUser->user_type == User::USER_TYPE_ADMIN){
                $redirect_to = 'admin.dashboard';
            }
            if($authUser->user_type == User::USER_TYPE_MANAGER){
                $redirect_to = 'manager.dashboard';
            }
        }
        return $redirect_to;
    }
    public function redirectToLogin($authUser)
    {
        $redirect_to = 'login';
        if(!empty($authUser->user_type)){
            if($authUser->user_type == User::USER_TYPE_SUPER_ADMIN){
                $redirect_to = 'super.admin.login';
            }
            if($authUser->user_type == User::USER_TYPE_ADMIN){
                $redirect_to = 'admin.login';
            }
            if($authUser->user_type == User::USER_TYPE_MANAGER){
                $redirect_to = 'manager.login';
            }
        }
        return $redirect_to;
    }

}
