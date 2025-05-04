<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            $path = $request->path();

            if (str_starts_with($path, 'admin')) {
                return route('admin.login');
            }

            if (str_starts_with($path, 'super-admin')) {
                return route('super.admin.login');
            }

            if (str_starts_with($path, 'manager')) {
                return route('manager.login');
            }

            return route('login'); // fallback
        }

        return null;
    }
}

