<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ventas = Auth::user()->roles;
        $vendedor=False;
        foreach ($ventas as $roles){
            if($roles->id == 3 or $roles->id == 1 or $roles->id ==4 or $roles->id ==7 ){
                $vendedor=True;
            }
        }
        if (auth()->user()->is_admin or $vendedor == true) {
            return $next($request);
        }
        else{
            abort(403);
        }  
    }
}
