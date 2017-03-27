<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model{

    public function add(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }

        if(!rq('question_id')||!rq('content')){
           return ['status'=>0,'msg'=>'question id and content required'];
        }
        
        $question = question_ins()->find(rq('question_id'));
        if(!$question){
            return ['status'=>0,'msg'=>'question not exists'];
        }

        $r = $this->where(['question_id'=>rq('question_id'),'user_id'=>session('user')->id])
             ->count();
        if($r){
            return ['status'=>0,'msg'=>'answer has exists'];
        }
        $this->content = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id = session('user')->id;

        return $this->save()? ['status'=>1,'msg'=>'add success']:['status'=>0,'msg'=>'add failed'];
    }

    public function updateAnswer(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }
        
        if(!rq('id')||!rq('content')){
            return ['status'=>0,'msg'=>'id and content required'];
        }

        $answer = $this->find(rq('id'));

        if($answer->user_id !=session('user')->id){
            return ['status'=>0,'msg'=>'access denied'];
        }

        $answer->content = rq('content');

        return $answer->save()? ['status'=>1,'msg'=>'update success']:['status'=>0,'msg'=>'update failed'];

    }

    public function read(){
        if(!rq('question_id')&&!rq('id')){
           return ['status'=>0,'msg'=>'question id and id required'];
        }
        if(rq('id')){
            $answer = $this->find(rq('id'));
            if(!$answer){
                return ['status'=>0,'msg'=>'answer not exists'];
            }else{
                return ['status'=>1,'data'=>$answer];
            }
        }
        
        $question = question_ins()->find(rq('question_id'));
        if(!$question){
            return ['status'=>0,'msg'=>'question not exists'];
        }

        $answers = $this->where('question_id',rq('question_id'))
                  ->get()
                  ->keyBy('id');
       
       return ['status'=>1,'data'=>$answers];
    }

    public function remove(){
        if(!rq('answer_id')){
            return ['status'=>0,'msg'=>'answer id required'];
        }
        $answer = $this->find(rq('answer_id'));
        if(!answer){
            return ['status'=>0,'msg'=>'answer not exists'];
        }
        if($answer->user_id!=session('user')->id){
            return ['status'=>0,'msg'=>'access dennied'];
        }
        return $answer->delete()?['status'=>1, 'msg'=>'success']:['status'=>0,'msg'=>'db failed'];
    }

    public function vote(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }

        if(!rq('id')||!rq('vote')){
            return ['status'=>0,'msg'=>'id or vote required'];
        }
        $answer = $this->find(rq('id'));
        if(!$answer){
            return ['status'=>0,'msg'=>'answer not exists'];
        }
        $voteCount = rq('vote')<=1?1:2;
        $vote = $answer
          ->users()
          ->newPivotStatement()
          ->where('user_id',session('user')->id)
          ->where('answer_id',rq('id'))
          ->delete();
        
        $answer->users()->attach(session('user')->id,['vote'=>$voteCount]);
        return ['status'=>1,'msg'=>'success'];
    }

    public function users(){
        return $this
           ->belongsToMany('App\Http\Models\User')
           ->withPivot('vote')
           ->withTimestamps();
    }
}
