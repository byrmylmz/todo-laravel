<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class EnsureTrialIsValid 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        if (auth()->user()->free_trial_days_left <= 0 ) {
            $user=auth()->user();
            $user->syncRoles('writer');
        }
        return $next($request);
    }
}
