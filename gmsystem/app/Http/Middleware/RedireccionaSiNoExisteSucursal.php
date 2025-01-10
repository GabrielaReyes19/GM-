<?php

namespace App\Http\Middleware;

use Closure;

class RedireccionaSiNoExisteSucursal
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
        $sucursal=session('pk_suc_id');
        if($sucursal==""){
            return redirect()->to('acceder');
        }else{
            return $next($request);
        }

    }
}
