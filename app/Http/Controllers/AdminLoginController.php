<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use App\Admin;
use Hash;
class AdminLoginController extends Controller
{
    //
    //登录页面
    public function login(Request $r){
        if($r -> isMethod('POST')){
            //控制器验证
            /*$this -> validate($r,[
                'User.username' => 'required|min:6',
                'User.password' => 'required|min:5'
            ],[
                'required' => ':attribute 不可为空',
                'min' => ':attribute 长度不符合要求'
            ],[
                'User.username' => '用户名',
                'User.password' => '密码'
            ]);*/
            //validator类验证
            $validator = \Validator::make($r -> input(),[
                'User.username' => 'required|min:5',
                'User.password' => 'required|min:5'
            ],[
                'required' => ':attribute 不可为空',
                'min' => ':attribute 长度不符合要求'
            ],[
                'User.username' => '用户名',
                'User.password' => '密码'
            ]);
            if($validator -> fails()){
                return redirect() -> back() -> withErrors($validator) -> withInput();
            }
            $postData = $r -> input('User');
            $user = new Admin();
            //根据用户名查询用户数据
            $userData = $user -> where('username',$postData['username']) -> first();
            if(!$userData)
                return redirect('AdminLogin/login') -> with('error','用户名不存在');
            if($userData -> status != 1)
                return redirect('AdminLogin/login') -> with('error','用户不可用');
            //检查密码是否正确
            $hashed_password = $userData->password;
            if(!Hash::check($postData['password'],$hashed_password))
                return redirect('AdminLogin/login') -> with('error','密码错误');
            $r -> session() -> put('username',$userData->username);
            $r -> session() -> put('user_id',$userData->id);
            Log::create([
                'username'=>$postData['username'],
                'user_id'=>$userData->id,
                'desc'=>"管理员{$postData['username']}登录",
            ]);
            return redirect('/');
        }
        return view('adminlogin.login');
    }

    //登出页面
    public function logout(Request $r){
        $r -> session() -> forget('username');
        $r -> session() -> forget('user_id');
        return redirect('AdminLogin/login');
    }
}
