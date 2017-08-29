<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Admin;
use Hash;
use App\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    private $admin;
    public function __construct()
    {
        $this -> admin = new Admin();
    }

    public function index(Request $r){
        if($r -> isMethod('POST')){
            $validator = \Validator::make($r -> input(),[
                'Admin.username' => 'required|min:5',
                'Admin.password' => 'required|min:5'
            ],[
                'required' => ':attribute 不可为空',
                'min' => ':attribute 长度不符合要求'
            ],[
                'Admin.username' => '用户名',
                'Admin.password' => '密码'
            ]);
            if($validator -> fails()){
                return redirect() -> back();
            }
            $data = $r -> input('Admin');
            $adminData = $this -> admin -> where('username',$data['username']) -> first();
            if($adminData)
                return redirect('admin') -> with('error','添加失败,用户名已存在');
            $this -> admin -> username = $data['username'];
            //加密密码
            $this -> admin -> password = bcrypt($data['password']);
            if($this -> admin -> save()){
                if(!empty($data['role'])){
                    $role = Role::where('id',$data['role'])->first();
                    $this -> admin ->attachRole($role); // 参数可以是Role对象，数组或id
                }
                Cache::forget('admins');
                return redirect('admin') -> with('success','添加成功');
            }
            return redirect('admin') -> with('error','添加失败');
        }
        $admins = [];
        if(Cache::has('admins')){
            $admins = Cache::get('admins');
        }else{
            $admins = Admin::where('status',1) -> paginate(10);
            Cache::put('admins',$admins,120);
        }
        $roles = Role::get();
        return view('admin.index',['admins'=>$admins,'roles'=>$roles]);
    }

    public function del(Request $r){
        $id = $r -> input('id');
        if(!is_numeric($id)){
            return response() -> json(['code' => 500,'msg' => '参数错误']);
            exit();
        }
        $admin = Admin::find($id);
        if($admin && $admin -> status != 0){
            if(Admin::where('id',$id)->update(['status'=>0])){
                Log::create([
                    'username'=>$r -> session() -> get('username'),
                    'user_id'=>$r -> session() -> get('user_id'),
                    'desc'=>"管理员{$r -> session() -> get('username')}删除ID为{$id}的管理员",
                ]);
                Cache::forget('admins');
                return response() -> json(['code' => 200,'msg' => '删除成功']);
                exit();
            }
            return response() -> json(['code' => 500,'msg' => '删除失败']);
            exit();
        }else{
            return response() -> json(['code' => 500,'msg' => '找不到对象']);
            exit();
        }
    }

    public function edit(Request $r){
        $id = $r -> input('id');
        if($r -> ajax()){
            if($r -> isMethod('GET')){
                $admin = Admin::find($id);
                $role = Role::get();
                $roleUser = DB::table('role_user')->where('user_id',$id)->first();
                if($admin){
                    return response() -> json(['status'=>200,'admins'=>$admin,'roles'=>$role,'roleuser'=>$roleUser]);
                    exit();
                }else{
                    return response() -> json(['status'=>500,'msg'=>'找不到对象,请重新选择']);
                    exit();
                }
            }
        }
        if(!is_numeric($id)){
            return response() -> json(['code' => 500,'msg' => '参数错误']);
            exit();
        }
        $admin = Admin::find($id);
        if($admin){
            $password = $r -> input('password');
            if(empty($password) || strlen($password) < 5){
                return response() -> json(['code' => 500,'msg' => '密码位数错误']);
                exit();
            }
            $username = $r -> input('username');
            if(empty($username) || strlen($username) < 5){
                return response() -> json(['code' => 500,'msg' => '用户名位数错误']);
                exit();
            }
            if(Admin::where('id',$id)->update(['password'=>bcrypt($password)])){
                Log::create([
                    'username'=>$r -> session() -> get('username'),
                    'user_id'=>$r -> session() -> get('user_id'),
                    'desc'=>"管理员{$r -> session() -> get('username')}修改ID为{$id}的管理员信息",
                ]);
                $roleId = $r -> input('role_id');
                //还是按照分配权限那样,先把用户的角色删除然后重新添加角色
                DB::table('role_user')->where('user_id',$admin->id) -> delete();
                $role = Role::where('id',$roleId)->first();
                $admin->attachRole($role); // 参数可以是Role对象，数组或id
                Cache::forget('admins');
                return response() -> json(['code' => 200,'msg' => '密码修改成功']);
                exit();
            }
            return response() -> json(['code' => 500,'msg' => '密码修改失败']);
            exit();
        }else{
            return response() -> json(['code' => 500,'msg' => '找不到对象']);
            exit();
        }
    }
}