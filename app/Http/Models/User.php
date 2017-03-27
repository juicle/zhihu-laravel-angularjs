<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model{

    public function signUp(){
        $username_password = $this->has_username_password();
        if(!$username_password){
            return ['status'=>0, 'msg'=>'password not null'];
        }
        $userName = $username_password[0];
        $password = $username_password[1];
        //检测是否存在
        $userExists = $this
        ->where('username', $userName)
        ->exists();
        if($userExists)
            return ['status'=>0, 'msgt'=>'user has exists'];
        //加密密码
        $hash_password = Hash::make($password);
        //dd($hash_password);
        //存入数据库
        $user = $this;
        $user->username = $userName;
        $user->password = $hash_password;
        if($user->save()){
            return ['status'=>1, 'msg'=>'success add', 'uid'=>$user->id]; 
        }
    
    }

    public function signIn(){
        $username_password = $this->has_username_password();
        if(!$username_password){
            return ['status'=>0, 'msg'=>'not null'];
        }
        $userName = $username_password[0];
        $password = $username_password[1];
        //检测用户名是否存在
        $user = $this->where('username', $userName)->first();
        if(!$user){
            return ['status'=>0, 'mst'=>'user not exitsts'];
        }else{
            $backPassword = $user->password;
            if(Hash::check($password,$backPassword)){
                session()->put('user',$user);
                //dd(session()->all());
                return ['status'=>1, 'msg'=>'success login','uid'=>$user->id];
            }else{
                return ['status'=>0, 'msg'=>'password wrong'];
            }
        }
    }

    public function logOut(){
        session()->forget('user'); 
        return ['status'=>1, 'msg'=>'success logout'];
    }

    public function has_username_password(){
        $userName = rq('username');
        $password = rq('password');
        //检测是否空
        if($userName&&$password){
            return [$userName, $password];
        }
        return false;
    }

    public function isLogin(){
        $isCheck = session('user') ? : false;
        //dd($isCheck);
        if($isCheck){
            return ['status'=>1, 'msg'=>'has login'];
        }else{
            return ['status'=>1, 'msg'=>'log out'];
        }
    }

    public function changepassword(){
        $isLogin = session('user') ? : false;
        if(!$isLogin){
           return err('not login');
        }
        if(!rq('old_password')||!rq('new_password')){
            return ['status'=>0,'msg'=>'password required'];
        }
        $user = $this->find(session('user')->id);

        if(!Hash::check(rq('old_password'),$user->password)){
            return ['status'=>0,'msg'=>'old password wrong'];
        }

        $user->password = Hash::make(rq('new_password'));
        
        return $user->save()?['status'=>1, 'msg'=>'success']:['status'=>0,'msg'=>'db failed'];

    }

    public function reset_password(){
        if(is_robot()){
           return err('retuired frequency');
        }
        if(!rq('phone')){
           return err('phone required');
        }
        $user = $this->where('phone',rq('phone'))->first();
        if(!$user){
           return err('invalid phone');
        }

        $captcha = $this->generate_captcha();

        $user->phone_captcha = $captcha;
        if($user->save()){
           $this->send_sms();
           session()->put('last_sms_time',time());
           return ['status'=>1, 'msg'=>'success'];
        }else{
           return ['status'=>0,'msg'=>'db failed'];
        }
    }
    
    public function validate_reset_password(){
        if($this->is_robot()){
           return err('retuired frequency');
        }
        if(!rq('phone')||!rq('phone_captcha')||!rq('new_password')){
           return err('phone and phonecaptcha and new_password required');
        }

        $user=$this->where([
            'phone'=>rq('phone'),
            'phone_captcha'=>rq('phone_captcha')
        ])->first();

        if(!$user){
            return err('phone or phonecaptcha wrong');
        }

        $user->password = Hash::make(rq('new_password'));
        if($user->save()){
            session()->put('last_sms_time',time());
            return ['status'=>1, 'msg'=>'success'];
        }else{
            return ['status'=>0,'msg'=>'db failed'];
        }
    }

    public function user_exists(){
        return ['status'=>1, 'data'=>['count'=>$this->where('username',rq('username'))->count()]];
    }

    public function user_info(){
        if(!rq('id')){
            return err('id required');
        }
        $exists = $this->find(rq('id'));
        if(!$exists){
            return err('user not exists');
        }
        $get = ['id','username','avator_url','intro'];
        $user = $this->find(rq('id'),$get);
        
        $data = $user->toArray();
        $answer_count = $user->answers()->count();
        $question_count = question_ins()->where('user_id',rq('id'))->count();
        $data['answer_count'] = $answer_count;
        $data['question_count'] = $question_count;
        return ['status'=>1,'data'=>$data];

    }

    public function is_robot($time=10){
        $current_time = time();
        $last_sms_time = session('last_sms_time');
        return !($current_time - $last_sms_time > $time);
        
    }

    public function generate_captcha(){
        return rand(1000,9999);
    }

    public function send_sms(){
        return true;
    }

    public function answers(){
        return $this
           ->belongsToMany('App\Http\Models\Answer')
           ->withPivot('vote')
           ->withTimestamps();
    }

    public function questions(){
        return $this
           ->belongsToMany('App\Http\Models\Question')
           ->withPivot('vote')
           ->withTimestamps();
    }
}