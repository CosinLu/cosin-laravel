<?php
/**
 * Created by PhpStorm.
 * User: Cosin
 * Date: 2017/7/22
 * Time: 下午12:14
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Cache;
use Hash;
use Illuminate\Http\Request;
class UserController extends Controller{

    public function show($id){
//        return view('user.profile',['user'=>User::findOrFail($id)]);
    }

    public function test(Request $r){
        return redirect('user/test1');
//        $arr = ['id'=>1,'name'=>'cosin','age'=>18];
//        return  response() -> json($arr);
    }

    public function test1(){
        echo 'hello';
    }

    public function get_session(Request $r){
//        $val = $r -> session() -> get('name');
//        $a = session('name');
        $c = Redis::get('name');
        $a = Redis::get('set');
        $b = session('name');
        $d = Redis::get('aaa');
        if(empty($d))
            echo 111;
        else
            echo 222;
        dd($d);
        print_r($b);
//        $c = Cache::store('redis') -> get('name');
//        Cache::forget('set');
        print_r($c);
        print_r($a);
//        print_r($val);
    }
    
    public function signup(){

    }

    public function index(Request $r){
        if($r -> isMethod('POST')){

        }
        $users = User::paginate(1);
        return view('user.index',['users'=>$users]);
    }
}