<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (isSuperAdmin()) {
            return $next($request);
        }
        return redirect()->route('admin.comics.index');
    }
}
