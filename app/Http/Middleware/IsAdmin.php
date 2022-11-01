<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()) {
            // The user is authorized and an administrator
            if (auth()->user()->is_admin == 1) {
                return $next($request);
            }
        } else {
            // User is not authorized == Unauthenticated
            if ($request->wantsJson()) {
                return response()->json(['data' => null, 'error' => 1, 'message' => 'User is not authorized!'], 201);

            }

            return redirect()->back()->with('error', "You don't have admin access.");
        }

        // The user is authorized but not an administrator
        if ($request->wantsJson()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        return redirect()->back()->with('error', "You don't have admin access.");
    }
}
