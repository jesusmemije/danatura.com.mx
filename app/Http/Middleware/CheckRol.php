<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckRol
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
        if(auth()->user()!=null){

        
        $tipo=auth()->user()->tipo;

        $tipos=DB::table('tiposuario')->where('id','=',$tipo)->first();

        $thetipo=$tipos->tipo;

        if($thetipo == 'Administrador' || $thetipo == 'Nutriologo' || $thetipo == 'Mayorista') {
            return $next($request);
        }
    }
        return redirect('/');

    
    }
}
