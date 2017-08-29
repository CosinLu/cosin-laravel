<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
function exit_json($code,$msg='',$data = array()){
    return ['status'=>$code,'msg'=>$msg,'data'=>$data];
    exit();
}
function user_ins(){
    return new App\User;
}
function question_ins(){
    return new App\Question;
}
function answer_ins(){
    return new App\Answer;
}
function comment_ins(){
    return new App\Comment;
}
function rq($key = null,$default = null){
    if(!$key) return Request::all();
    return Request::get($key,$default);
}
Route::any('user/signup',function(){
    return user_ins() -> signup();
});

Route::any('user/login',function(){
    return user_ins() -> login();
});

Route::any('user/logout',function(){
    return user_ins() -> logout();
});

Route::any('question/add',function(){
    return question_ins() -> add();
});

Route::any('question/change',function(){
    return question_ins() -> change();
});

Route::any('question/read',function(){
    return question_ins() -> read();
});

Route::any('question/remove',function(){
    return question_ins() -> remove();
});

Route::any('answer/add',function(){
    return answer_ins() -> add();
});

Route::any('answer/change',function(){
    return answer_ins() -> change();
});

Route::any('answer/read',function(){
    return answer_ins() -> read();
});

Route::any('answer/remove',function(){
    return answer_ins() -> remove();
});


Route::any('comment/add',function(){
    return comment_ins() -> add();
});

Route::any('comment/read',function(){
    return comment_ins() -> read();
});

Route::any('comment/remove',function(){
    return comment_ins() -> remove();
});

Route::any('AdminLogin/login','AdminLoginController@login');
Route::any('AdminLogin/logout','AdminLoginController@logout');

Route::group(['middleware'=>['web']],function(){
    Route::any('admin','AdminController@index')->middleware('checkLogin','checkAuth');
    Route::any('admin/edit','AdminController@edit')->middleware('checkLogin','checkAuth');
    Route::any('admin/del','AdminController@del')->middleware('checkLogin','checkAuth');
    Route::any('/','IndexController@index')->middleware('checkLogin','checkAuth');
    Route::any('auth','AuthController@index')->middleware('checkLogin','checkAuth');
    Route::any('auth/role','AuthController@role')->middleware('checkLogin','checkAuth');
    Route::any('auth/roleUsers','AuthController@roleUsers')->middleware('checkLogin','checkAuth');
    Route::any('auth/permission','AuthController@permission')->middleware('checkLogin','checkAuth');
    Route::any('auth/permissionRole','AuthController@permissionRole')->middleware('checkLogin','checkAuth');
    Route::any('auth/checkRole','AuthController@checkRole')->middleware('checkLogin','checkAuth');
    Route::any('auth/addPermission','AuthController@addPermission')->middleware('checkLogin','checkAuth');
    Route::any('auth/addRole','AuthController@addRole')->middleware('checkLogin','checkAuth');
    Route::any('auth/editRole','AuthController@editRole')->middleware('checkLogin','checkAuth');
    Route::any('auth/doEditRole','AuthController@doEditRole')->middleware('checkLogin','checkAuth');
    Route::any('article','ArticleController@index')->middleware('checkLogin','checkAuth');
    Route::any('index/clearCache',['uses'=>'IndexController@clearCache'])->middleware('checkLogin','checkAuth');
});
