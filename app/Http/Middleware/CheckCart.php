<?php

namespace App\Http\Middleware;

use Closure;

class CheckCart
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
        if(\Cart::session($request->user()->id)->isEmpty()){
            return \redirect('carts');
        }
        return $next($request);
    }
}
