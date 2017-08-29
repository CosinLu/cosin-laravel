<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;

class CheckAuth
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
        $user = Admin::where('id',$request->session()->get('user_id'))->first();
//        dd($request -> getPathInfo());
        if(!$user -> can($request -> getPathInfo())){
//            die('你没有该权限');
        }
        return $next($request);
    }
}
