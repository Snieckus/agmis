<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if(!Auth::check())
            return redirect('login');

        if(auth()->user()->role == $role){
            return $next($request);
        }

        return redirect()->route('home');
    }
}
