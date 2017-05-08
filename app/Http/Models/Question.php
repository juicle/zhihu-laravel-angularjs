<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model{
    
    public function add(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }

        if(!rq('title')){
            return ['status'=>0,'msg'=>'required title'];
        }
        $question_exists = $this
        ->where('title', rq('title'))
        ->exists();
        if($question_exists){
            return ['status'=>0,'msg'=>'question has add'];
        }

        $this->title = rq('title');



        if(!rq('desc')){
            return ['status'=>0,'msg'=>'required desc'];
        }

        $this->desc = rq('desc');
        $this->user_id = session('user')->id;
        

         return $this->save() ?
           ['status'=>1, 'msg'=>'success']:['status'=>0,'msg'=>'db failed'];
    }

    public function del(){

    }

    public function change(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }

        if(!rq('qid')){
            return ['status'=>0,'msg'=>'required qid'];
        }

        $question = $this->find(rq('qid'));

        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];

        if($question->user_id != session('user')->id){
            return ['status'=>0,'msg'=>'access denied'];
        }
        
        if(rq('title'))
            $question->title = rq('title');

        if(rq('desc'))
            $question->desc = rq('desc');   

        return $question->save() ?
            ['status'=>1, 'msg'=>'update success']:['status'=>0,'msg'=>'update failed'];
    }

    public function read(){
        if(rq('qid')){
            return ['status'=>1,'data'=>$this->find(rq('qid'))];
        }

        // $limit = rq('limit')?:15;
        // $skip = (rq('page')?rq('page') - 1 : 0) * $limit;
        list($limit,$skip) = paginage(rq('page'),rq('limit'));
        $r = $this
            ->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            ->get(['id','title','desc'])
            ->keyBy('id');
        return ['status'=>1,'data'=>$r];

    }

    public function remove(){

        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return ['status'=>0,'msg'=>'not login'];
        }

        if(!rq('qid')){
            return ['status'=>0,'msg'=>'required qid'];
        }

        $question = $this->find(rq('qid'));

        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];
       
        if($question->user_id != session('user')->id){
            return ['status'=>0,'msg'=>'access denied'];
        }

        return $question->delete() ?
            ['status'=>1, 'msg'=>'del success']:['status'=>0,'msg'=>'del failed'];


    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}