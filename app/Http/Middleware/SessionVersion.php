<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SessionVersion
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user()) {
            if (Auth::viaRemember() && !$request->session()->has('auth_version')) $request->session()->put('auth_version', $user->auth_version);
            if ($request->session()->get('auth_version', -1) !== $user->auth_version) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                if (in_array('auth', $request->route()?->gatherMiddleware() ?? [], true)) throw new \Illuminate\Auth\AuthenticationException('Session expired.', ['web'], '/login.php');
            }
        }
        return $next($request);
    }
}
