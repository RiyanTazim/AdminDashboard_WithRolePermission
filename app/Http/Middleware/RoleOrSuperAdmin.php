<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class RoleOrSuperAdmin
{
    use HasRoles;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

     public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Super Admin')) {
                return $next($request); // bypass everything
            }

            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Unauthorized access.');
    }
}
