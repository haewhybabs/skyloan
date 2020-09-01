<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
use Closure;

class apiauth
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
        $token=$request->header('token');

        $verify=DB::table('api_auth')->where('token',$token)->first();
        if(!$verify){

            return response()->json(['message'=>'App key not found '], 401);

        }
        return $next($request);
    }
}
