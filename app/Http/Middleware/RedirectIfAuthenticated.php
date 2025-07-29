<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirección basada en el rol del usuario
                $role = Auth::guard($guard)->user()->role;
                
                switch ($role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'user':
                        return redirect()->route('user.dashboard');
                    case 'caretaker':
                        return redirect()->route('caretaker.dashboard');
                    default:
                        return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}