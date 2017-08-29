<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //添加评论
    public function add(){
        //检查出否登录
        if(!user_ins()->is_logged_in())
            return exit_json(0,'login required');
        //检查是否有评论内容
        if(!rq('content'))
            return exit_json(0,'empty content');
        //检查是否存在问题id或回答id
        if(
            (!rq('question_id') && !rq('answer_id')) ||
            (rq('question_id') && rq('answer_id'))
        )
            return exit_json(0,'question_id or answer_id is required');

        if(rq('question_id')){
            //评论问题
            $question = question_ins()->find(rq('question_id'));
            //检查问题是否存在
            if(!$question) return exit_json(0,'question not exists');
            $this -> question_id = rq('question_id');
        }else{
            //评论答案
            $answer = answer_ins()->find(rq('answer_id'));
            //检查答案是否存在
            if(!$answer) return exit_json(0,'answer not exists');
            $this -> answer_id = rq('answer_id');
        }
        //检查是否在回复评论
        if(rq('reply_to')){
            $target = $this -> find(rq('reply_to'));
            //检查目标回复是否存在
            if(!$target) return exit_json(0,'target comment not exists');
            //检查是否在回复自己的评论
            if($target -> user_id == session('user_id'))
                return exit_json(0,'cannot reply to yourself');
            $this -> reply_to = rq('reply_to');
        }
        $this -> content = rq('content');
        $this -> user_id = session('user_id');
        //保存数据
        return $this -> save() ? exit_json (1,'insert is success',$this -> id) : exit_json(0,'db insert failed');
    }

    //查看评论
    public function read(){
        if(rq('question_id')){
            $question = question_ins() -> find(rq('question_id'));
            if(!$question) return exit_json(0,'question not exists');
            $data = $this -> where('question_id',rq('question_id')) -> get();
        }else{
            $answer = answer_ins() -> find(rq('answer_id'));
            if(!$answer) return exit_json(0,'answer not exists');
            $data = $this -> where('answer_id',rq('answer_id')) -> get();
        }
        $data = $data -> get() -> keyBy('id');
        return exit_json(1,'data is exist',$data);
    }

    //删除评论
    public function remove(){
        //检查出否登录
        if(!user_ins()->is_logged_in())
            return exit_json(0,'login required');

        if(!rq('id'))
            return exit_json(0,'id is required');

        $comment = $this -> find(rq('id'));
        if(!$comment) return exit_json(0,'comment not exists');

        if($comment -> user_id != session('user_id'))
            return exit_json(0,'permission denied');
        //先删除此评论下所有的回复
        $this -> where('reply_to',rq('id')) -> delete();
        return $comment -> delete() ? exit_json(1,'delete is seccess') : exit_json(0,'db delete failed');
    }

}
