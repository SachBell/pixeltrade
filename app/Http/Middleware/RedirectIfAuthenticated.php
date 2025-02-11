<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->redirectByRole($request->user());
            }
        }

        return $next($request);
    }

    private function redirectByRole($user): RedirectResponse
    {
        if ($user->hasRole('superadmin')) {
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        } elseif ($user->hasRole('server_owner')) {
            return redirect()->intended(RouteServiceProvider::USER_HOME);
        }
    }
}
