<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        // If user_type not in allowed types, abort
        if (!in_array($user->user_type, $types)) {
            abort(403, 'Unauthorized Access. you are loged in as '.User::USER_TYPE_TEXT[$user->user_type] ?? User::USER_TYPE_UNKNOWN);
        }

        return $next($request);
    }
}
