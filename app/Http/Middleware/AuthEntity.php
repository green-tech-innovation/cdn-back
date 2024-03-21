<?php

namespace App\Http\Middleware;

use App\Models\Entity;
use Closure;
use Illuminate\Http\Request;

class AuthEntity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->guard('api')->user();

        if ($role == "sector_patner") {
            if(Entity::where('user_id', $user->id)->where('type', strtoupper("patner"))->where('type', strtoupper("sector"))->count() == 1) {
                return $next($request);
            }
        } else {
            if(Entity::where('user_id', $user->id)->where('type', strtoupper($role))->count() == 1) {
                return $next($request);
            }
        }
        return $next($request);
        //return response()->redirectToRoute("unauthentized");
    }
}
