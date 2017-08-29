<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //设置批赋值
    protected $fillable = ['username','user_id','modules','time','status','desc'];
}
