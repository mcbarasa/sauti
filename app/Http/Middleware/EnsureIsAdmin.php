<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin extends \Illuminate\Auth\Middleware\Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        // Not logged in → redirect to login
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Logged in but not the admin email → abort
        if (Auth::user()->email !== config('admin.email')) {
            abort(404);
        }

        return $next($request);
    }
}