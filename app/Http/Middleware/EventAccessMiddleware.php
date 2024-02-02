<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Organizer;
use App\Models\User;

class EventAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user) {
            if ($user->role === 'Organizer' && Organizer::where('id', $user->id)->exists()) {
                return $next($request);
            }
            if ($user->role === 'User' && User::where('id', $user->id)->exists()) {
                if ($request->route()->getName() === 'events.index' || $request->route()->getName() === 'events.show') {
                    return $next($request);
                }
            }
        }

        // If the user is not authenticated or doesn't have the appropriate role, abort the request
        abort(403, 'Access denied.');
    }
}