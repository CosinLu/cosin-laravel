<?php
/**
 * Created by PhpStorm.
 * User: Cosin
 * Date: 2017/7/30
 * Time: 下午9:12
 */
namespace App\Http\Middleware;
use Closure;

class Activity{
    //此方法为固定方法,前置操作
    public function handle($request,Closure $next){
        if(tiem() < strtotime('2016-06-05')){
            return redirect('user/test1');
        }
        return $next($request);
    }
}