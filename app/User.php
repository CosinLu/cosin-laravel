<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;
class User extends Model
{
    //
    public function signup(){
        //检查用户名是否存在
        $username_and_password = $this -> username_and_password();

        if(!$username_and_password)
            return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];
        $username = $username_and_password[0];
        $password = $username_and_password[1];
        $user_exists = $this -> where('username',$username) -> exists();
        if($user_exists)
            return ['status'=>0,'msg'=>'用户名已存在'];
        //加密密码
        $hashed_password = bcrypt($password);
        //存入数据库
        $user = $this;
        $user -> password = $hashed_password;
        $user -> username = $username;
        if($user -> save())
            return ['status'=>1,'id'=>$user->id];
        else
            require ['status'=>0,'msg'=>'db insert failed'];

    }

    //登录
    public function login(){
        //检查用户名和密码是否存在
        $username_and_password = $this -> username_and_password();
        if(!$username_and_password)
            return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];
        $username = $username_and_password[0];
        $password = $username_and_password[1];
        //检查用户是否存在
        $user = $this -> where('username',$username)->first();
        if(!$user)
            return ['status'=>0,'msg'=>'用户不存在'];
        //检查密码是否正确
        $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password))
            return ['status'=>0,'msg'=>'密码有误'];
        session() -> put('username',$user->username);
        session() -> put('user_id',$user->id);
        return ['status'=>1,'id'=>$user->id];
    }

    public function username_and_password(){
        $username = rq('username');
        $password = rq('password');
        if($username && $password)
            return [$username,$password];
        return false;
    }

    //登出api
    public function logout(){
        //删除session中的username和user_id
//        session() -> put('username',null);
//        session() -> put('user_id',null);
//        session() -> flush();
        session() -> forget('username');
        session() -> forget('user_id');
        return ['status'=>1,'msg'=>'logout is success'];
    }

    //检测用户是否登录
    public function is_logged_in(){
        //如果session中存在user_id就返回user_id否则返回FALSE
        return session('user_id') ? : false;
    }

    public function answers(){
        return $this -> belongsToMany('App\Answer')->withPivot('vote')->withTimestamps();
    }

}
