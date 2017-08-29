<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Role;
use App\Admin;
use App\Permission;
use App\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //
    public function index(Request $request){
        if(Cache::has('permissions')){
            $permissions = Cache::get('permissions');
        }else{
            $permissions = Permission::where('pid',0)->get();
            foreach($permissions as $key => $permission){
                $permission->child = Permission::where('pid',$permission -> id)->get();
            }
            Cache::put('permissions',$permissions,120);
        }

        if(Cache::has('roles')){
            $roles = Cache::get('roles');
        }else{
            $roles = Role::paginate(10);
            Cache::put('roles',$roles,120);
        }
        return view('auth.index',['roles'=>$roles,'permissions'=>$permissions]);
    }


    //添加权限
    public function addPermission(Request $request){
        //控制器验证
        $this -> validate($request,[
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ],[
            'required' => ':attribute 不可为空',
        ],[
            'name' => '权限名称',
            'display_name' => '可见名称',
            'description' => '详细描述',
        ]);
        $name = $request -> input('name');
        $display_name = $request -> input('display_name');
        $description = $request -> input('description');
        $parent_per = $request -> input('parent_per');
        $createPost = new Permission();
        $existData =$createPost -> where('name',$name) -> first();
        if($existData){
            return redirect() -> back() -> with('error','此权限名称已存在');
            exit();
        }
        $createPost->name = $name;
        $createPost->display_name = $display_name;
        $createPost->description = $description;
        $createPost->pid = $parent_per;
        if($createPost->save())
            Cache::forget('permissions');
        Log::create([
            'username'=>session()->get('username'),
            'user_id'=>session()->get('user_id'),
            'desc'=>"管理员".session()->get('username').'添加权限'.$display_name,
        ]);
        return redirect('auth') -> with('success','添加成功');
        exit();
    }

    //添加角色
    public function addRole(Request $request){
        //控制器验证
        $this -> validate($request,[
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ],[
            'required' => ':attribute 不可为空',
        ],[
            'name' => '角色名称',
            'display_name' => '可见名称',
            'description' => '详细描述',
        ]);
        $role = new Role();
        $name = $request -> input('name');
        $existData = $role -> where('name',$name) -> first();
        if($existData){
            return redirect() -> back() -> with('error','此角色名称已存在');
            exit();
        }
        $display_name = $request -> input('display_name');
        $description = $request -> input('description');
        $role -> name = $name;
        $role -> display_name = $display_name;
        $role -> description = $description;
        $permissions = $request -> input('permission');
        if($role -> save()){
            Cache::forget('roles');
            if($permissions){
                $role->attachPermissions($permissions); // 参数可以是Role对象，数组或id
            }
            Log::create([
                'username'=>session()->get('username'),
                'user_id'=>session()->get('user_id'),
                'desc'=>"管理员".session()->get('username').'添加角色'.$display_name,
            ]);
            return redirect('auth/') -> with('success','角色添加成功');
            exit();
        }else{
            return redirect() -> back('error','角色添加失败');
            exit();
        }
    }

    //编辑角色
    public function editRole(Request $request){
        $id = $request -> input('id');
        if(!is_numeric($id) && $id < 0){
            return response() -> json(['status'=>500,'msg'=>'参数错误']);
            exit();
        }
        $roleData = Role::where('id',$id)->first();
        if(!$roleData){
            return response() -> json(['status'=>500,'msg'=>'数据对象不存在,请刷新页面后重新操作']);
            exit();
        }
        if(Cache::has('permissions')){
            $permissions = Cache::get('permissions');
        }else{
            $permissions = Permission::where('pid',0)->get();
            foreach($permissions as $key => $permission){
                $permission->child = Permission::where('pid',$permission -> id)->get();
            }
            Cache::put('permissions',$permissions,120);
        }
        $roleData -> permissions = DB::table('permission_role')->where('role_id',$roleData -> id)->pluck('permission_id')->toArray();
        return view('auth.edit',['roleData'=>$roleData,'permissions'=>$permissions]);
        exit();
    }

    //处理编辑角色
    public function doEditRole(Request $request){
        //控制器验证
        $this -> validate($request,[
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ],[
            'required' => ':attribute 不可为空',
        ],[
            'name' => '角色名称',
            'display_name' => '可见名称',
            'description' => '详细描述',
        ]);
        $id = $request -> input('id');
        $role = Role::where('id',$id)->first();
        $name = $request -> input('name');
        $display_name = $request -> input('display_name');
        $description = $request -> input('description');
        $permissions = $request -> input('permission');
        if($role -> where('id',$id) -> update(['name'=>$name,'display_name'=>$display_name,'description'=>$description])){
            Cache::forget('roles');
            //判断是否提交权限
            if($permissions){
                //如果有,这里采取最简单的方法,把之前的权限全部清空然后添加新的权限
                DB::table('permission_role')->where('role_id',$id)->delete();
                $role->attachPermissions($permissions); // 参数可以是Role对象，数组或id
            }
            Log::create([
                'username'=>session()->get('username'),
                'user_id'=>session()->get('user_id'),
                'desc'=>"管理员".session()->get('username').'编辑角色'.$display_name,
            ]);
            return redirect('auth/') -> with('success','角色编辑成功');
            exit();
        }else{
            return redirect() -> back('error','角色编辑失败');
            exit();
        }
    }

    //添加角色
    public function role(){
        $owner = new Role();
        $owner->name = 'artcle_manager';
        $owner->display_name = '文章管理员';
        $owner->description = '负责有关文章的所有操作';
        $owner->save();

        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = '超级管理员';
        $admin->description = '管理所有项目模块';
        $admin->save();
    }

    //为角色赋予权限
    public function roleUsers(){
        $admin = Role::where('name','admin')->first();
        $user = Admin::where('username', '=', 'cosin')->first();
        $user->attachRole($admin); // 参数可以是Role对象，数组或id
    }


    //给角色添加相应操作权限
    public function permissionRole(){
        //添加单个权限
        /*$articleManager = Role::where('name','article_manager')->first();
        $permission = Permission::where('name','create-article')->first();
        $articleManager->attachPermission($permission);*/
//等价于 $owner->perms()->sync(array($createPost-
        //批量添加权限
        $articleManager = Role::where('name','admin')->first();
        $permissionArticle = Permission::where('name','create-article')->first();
        $permissionAdmin = Permission::where('name','edit-admin-password')->first();
        $articleManager->attachPermissions(array($permissionArticle, $permissionAdmin));
//等价于 $admin->perms()->sync(array($createPost->id, $editUser->id));

    }

    //验证权限
    public function checkRole(){
        //先查询出用户数据
        $user = Admin::where('username', '=', 'cosin')->first();
        echo $user->hasRole('article_manager'); // false
        echo 'hehe'.'<br />';
        echo $user->hasRole('admin'); // true
        echo 'haha'.'<br />';
        echo $user->can('edit-admin-password'); // true
        echo 'heihei'.'<br />';
        echo $user->can('create-article'); // true
    }
}
