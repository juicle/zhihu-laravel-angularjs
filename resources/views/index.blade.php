<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="zhihu" userid="{{session('user')?session('user')->id:0}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>index</title>
        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <link href="/node_modules/normalize-css/normalize.css" rel="stylesheet">
        <!-- Js -->
        <script src="/node_modules/jquery/dist/jquery.js"></script>
        <script src="/node_modules/angular/angular.js"></script>
        <script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/common.js"></script>
        <script src="/js/user.js"></script>
        <script src="/js/question.js"></script>
        <script src="/js/answer.js"></script>
    </head>
    <body>
       <div class="navbar  clearfix">
         <div class="container">
             <div class="fl">
               <div class="navbar-item brand" ui-sref="home">知乎</div>
               <form id="quick_ask" ng-controller="QuestionController" name="question_form" ng-submit="Question.go_add_question()">
                  <div class="navbar-item"><input type="text" ng-model="Question.new_question.title"></div>
                  <div class="navbar-item"><button type="submit">提问</button></div>
               </form>
               
             </div>
             <div class="fr">
               <div ui-sref="home" class="navbar-item">首页</div>
               @if(is_signin())
               <div class="navbar-item">{{session('user')->username}}</div>
               <a href="{{url('/api/logout')}}" class="navbar-item">登出</a>
               @else
               <div ui-sref="login" class="navbar-item">登录</div>
               <div ui-sref="register" class="navbar-item">注册</div>
               @endif
               
             </div>
         </div>
       </div>
       <div class="page">
          <div ui-view></div>
       </div>
    </body>
    
</html>
