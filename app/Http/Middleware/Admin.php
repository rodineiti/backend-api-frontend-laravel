<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Admin
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
        if (!auth()->user()->admin)
        {
            Session::flash('info', 'Seu usuário não tem previlégios para realizar esta operação.');
            return redirect()->back();
        }
        return $next($request);
    }
}
