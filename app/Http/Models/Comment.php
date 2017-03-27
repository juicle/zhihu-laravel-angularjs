<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    
    public function add(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }

        
        if(!rq('content')){
            return ['status'=>0,'msg'=>'required content'];
        }

        if(
            !rq('question_id')&&!rq('answer_id') ||
            rq('question_id')&&rq('answer_id')
        ){
            return ['status'=>0,'msg'=>'question_id or answer_id required'];
        }

        if(rq('question_id')){
            $question = question_ins()->find(rq('question_id'));
            if(!$question){
                return ['status'=>0,'msg'=>'question not exists'];
            }else{
                $this->question_id = rq('question_id');
            }
        }else{
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer){
                return ['status'=>0,'msg'=>'answer not exists'];
            }else{
                $this->answer_id = rq('answer_id');
            }
        }
        
        if(rq('reply_to')){
            $target = $this->find(rq('reply_to'));
            if(!$target){
                return ['status'=>0,'msg'=>'comment not exists'];
            }else{
                if($target->user_id == session('user')->id){
                    return ['status'=>0,'msg'=>'you cannot reply to yourself'];
                }
                $this->reply_to = rq('reply_to');
            }
        }
        $this->content = rq('content');
        $this->user_id = session('user')->id;

        return $this->save() ?
           ['status'=>1, 'id'=>$this->id]:['status'=>0,'msg'=>'db failed'];

       
    }

    public function read(){

        if(!rq('question_id')&&!rq('answer_id')){
            return ['status'=>0,'msg'=>'id required'];
        }
        if(rq('question_id')){
            $question = question_ins()->find(rq('question_id'));
            if(!$question)  return ['status'=>0,'msg'=>'question not exists'];
            $data = $this->where('question_id',rq('question_id'))->get();     
        }else{
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
            $data = $this->where('answer_id',rq('answer_id'))->get();
        }
        return ['status'=>1,'data'=>$data->keyBy('id')];
    }

    public function remove(){
        $isLogin = session('user') ? : false;
        if(!$isLogin)
           return ['status'=>0,'msg'=>'not login'];
        

        if(!rq('id'))
            return ['status'=>0,'msg'=>'id required'];
        
        $comment = $this->find(rq('id'));

        if(!$comment) return ['status'=>0,'msg'=>'comment not exists'];

        if($comment->user_id != session('user')->id){
            return ['status'=>0,'msg'=>'acces dennied'];
        }
        
        $this->where('reply_to',rq('id'))->delete();
        return $comment->delete()?['status'=>1, 'msg'=>'success']:['status'=>0,'msg'=>'db failed'];
        
    }

}
