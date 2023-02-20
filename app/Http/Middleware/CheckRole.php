<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $allowedRoles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        if (in_array($user->user_type_ID, $allowedRoles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
