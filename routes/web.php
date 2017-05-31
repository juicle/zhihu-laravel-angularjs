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
function paginate($page=1, $limit=16){
    $limit = $limit?:6;
    $skip = ($page?$page-1:0) * $limit;
    return [$limit,$skip];
}

function err($msg=null){
    return ['status'=>0,'msg'=>$msg];
}

function suc($data=null){
    return ['status'=>1,'data'=>$data];
}

function rq($key=null, $default=null){
    if(!$key) return Request::all();
    return Request::get($key, $default);
}

function user_ins(){
    return new App\Http\Models\User;
}

function question_ins(){
    return new App\Http\Models\Question;
}

function answer_ins(){
    return new App\Http\Models\Answer;
}

function comment_ins(){
    return new App\Http\Models\Comment;
}

function is_signin(){
    return session('user') ? : false;
}

Route::get('/', function () {
    return view('index');
});


Route::get('api', function(){
    return ['version'=>'1.0'];
});

Route::any('api/signup', function(){
    return user_ins()->signUp();
});

Route::any('api/user/exists', function(){
    return user_ins()->user_exists();
});

Route::any('api/signin', function(){
    return user_ins()->signIn();
});

Route::any('api/logout', function(){
    return user_ins()->logOut();
});

Route::any('api/islogin', function(){
    return user_ins()->isLogin();
});

Route::any('api/user/changepassword', function(){
    return user_ins()->changepassword();
});

Route::any('api/user/reset_password', function(){
    return user_ins()->reset_password();
});

Route::any('api/user/validate_password', function(){
    return user_ins()->validate_reset_password();
});

Route::any('api/user/info', function(){
    return user_ins()->user_info();
});

Route::any('api/question/create', function(){
   return question_ins()->add();
});

Route::any('api/question/update', function(){
   return question_ins()->change();
});

Route::any('api/question/read', function(){
   return question_ins()->read();
});

Route::any('api/question/remove', function(){
   return question_ins()->remove();
});

Route::any('api/answer/add', function(){
   return answer_ins()->add();
});

Route::any('api/answer/change', function(){
   return answer_ins()->updateAnswer();
});

Route::any('api/answer/read', function(){
   return answer_ins()->read();
});

Route::any('api/answer/vote', function(){
   return answer_ins()->vote();
});

Route::any('api/answer/remove', function(){
   return answer_ins()->remove();
});

Route::any('api/comment/add', function(){
   return comment_ins()->add();
});

Route::any('api/comment/read', function(){
   return comment_ins()->read();
});

Route::any('api/comment/remove', function(){
   return comment_ins()->remove();
});

Route::any('api/timeline', 'CommonController@timeline');

Route::get('tpl/page/home', function(){
  return view('page.home');
});
