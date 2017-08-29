<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //添加回答
    public function add(){
        //检查用户是否登录
        if(!user_ins() -> is_logged_in())
            return ['status'=>0,'msg'=>'login required'];
        //检查问题id和回答内容是否存在
        if(!rq('question_id') || !rq('content'))
            return ['status'=>0,'msg'=>'question_id and  content are required'];
        //查询问题是否存在
        $question = question_ins() -> find(rq('question_id'));
        if(!$question) return ['0','msg'=>'question not exists'];
        //检查是否重复回答
        $answered = $this -> where(['question_id'=>rq('question_id'),'user_id'=>session('user_id')]) -> count();
        if($answered)
            return exit_json(0,'duplicate answers');
        //保存数据
        $this -> content = rq('content');
        $this -> question_id = rq('question_id');
        $this -> user_id = session('user_id');
        return $this -> save() ? exit_json(1,'insert is success',$this -> id) : exit_json(0,'db insert failed');
    }

    //更新回答
    public function change(){
        //检查用户是否登录
        if(!user_ins() -> is_logged_in())
            return exit_json(0,'login required');
        if(!rq('id') || !rq('content'))
            return exit_json(0,'id and content are required');
        $answer = $this -> find(rq('id'));
        if($answer -> user_id != session('user_id'))
            return exit_json(0,'permission denied');
        $answer -> content = rq('content');
        return $answer -> save() ? exit_json(1,'change is success') : exit_json(0,'change is failed');
    }

    //查看回答
    public function read(){
        //检查回答id和问题id是否存在
        if(!rq('id') && !rq('question_id'))
            return exit_json(0,'id or question is required');
        //查看单个回答
        if(rq('id')){
            $answer = $this -> find(rq('id'));
            if(!$answer)
                return exit_json(0,'answer not exists');
            return exit_json(1,'answer is success',$answer);
        }
        //在查看回答前检查问题是否存在
        if(!question_ins() -> find(rq('question_id')))
            return exit_json(0,'question not exists');
        //查看同一个问题下的所有回答
        $answer = $this -> where('question_id',rq('question_id'))
            -> get()
            ->keyBy('id');
        return exit_json(1,'answer is success',$answer);
    }

    public function vote(){
        //检查用户是否登录
        if(!user_ins() -> is_logged_in())
            return exit_json(0,'login required');
        if(!rq('id') || !rq('vote'))
            return exit_json(0,'id and vote are required');
        $answer = $this -> find(rq('id'));
        if(!$answer) return exit_json(0,'answer not exists');
        //检查此用户是否在相同问题下投过票
        $vote= $answer -> users()
            -> newPivotStatement()
            -> where('user_id',session('user_id'))
            ->where('answer_id',rq('id'))
            ->first();
        if($vote)
            $vote ->delete();
        $answer -> users() -> attach(session('user_id'));
        return exit_json(1);
    }

    public function users(){
        return $this -> belongsToMany('App\User')->withPivot('vote')->withTimestamps();
    }

}
