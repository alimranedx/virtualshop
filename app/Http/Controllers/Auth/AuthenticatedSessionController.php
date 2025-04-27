<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $authUser = Auth::user();
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

        return redirect()->intended(route($redirect_to, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
