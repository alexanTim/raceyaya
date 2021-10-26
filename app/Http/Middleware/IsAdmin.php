<?php

namespace App\Http\Middleware;

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
		
		
		if(auth()->check()) {
			 
			if(auth()->user()->isAdmin() == 1){				
				//return redirect('admin');
			}
			
			if(auth()->user()->isAdmin() == 2){
				//return redirect('home2');
			}
			return $next($request);
		}
		 return $next($request);
    }
}