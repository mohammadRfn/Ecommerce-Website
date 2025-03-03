<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            Log::info('CheckRole: User not logged in.');
            return redirect()->route('backpack.auth.login');
        }

        $user = auth()->user();
        Log::info('CheckRole: User role is: ' . $user->role);
        Log::info('CheckRole: Allowed roles are: ' . implode(', ', $roles));

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        Log::info('CheckRole: User role not authorized.');
        abort(403, 'Forbidden. User does not have the right roles.');
    }
}
