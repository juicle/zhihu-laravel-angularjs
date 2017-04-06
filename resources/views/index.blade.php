<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="zhihu">
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
    </head>
    <body>
       <div class="navbar  clearfix">
         <div class="container">
             <div class="fl">
               <div class="navbar-item brand">知乎</div>
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
    <script type="text/ng-template" id="home.tpl">
      <div class="home container">
          首页Laravel 框架对系统环境有一些要求。当然，所有这些要求在 Laravel Homestead 虚拟机中都是预装好的：
- PHP >= 5.5.9 - OpenSSL PHP 扩展 - PDO PHP 扩展 - Mbstring PHP 扩展 - Tokenizer PHP 扩展
安装 LaravelLaravel 利用 Composer（Composer 中文）来管理其自身的依赖包。因此，在使用 Laravel 之前，请务必确保在你的机器上已经安装了 Composer 。如果你是下载“一键安装包”的话，可以暂时不用安装 Composer，等熟悉 Laravel 了再回头摸索，免得上来就遇到钉子。
下载 Laravel 一键安装包安装 Composer 或通过 Composer 下载 Laravel 的依赖包时都可能被墙，为了方便大家学习和开发 Laravel 应用，Laravel 中文网已经提供了 Laravel 各个版本的一键安装包。这些一键安装包都已经集成了所有依赖（也就是已经执行过 composer install 了，vendor 目录已经就绪）。
下载地址：http://www.golaravel.com/download/另外，一键安装包还包含了以下修改：
      </div>
    </script>

    <script type="text/ng-template" id="login.tpl">
    <div class="login container signin" ng-controller="SigninController">
        <div class="card">
          <h1>登录</h1>
          <form ng-submit="User.signin()" name="signin_form">
              <div class="input-group">
                 <label>用户名:</label>
                 <input type="text" ng-model="User.signin_data.username" name="username"  required>
              </div>
              <div class="input-group">
                 <label>密码:</label>
                 <input type="password" ng-model="User.signin_data.password" name="password"  required>
                 <div class="input-error-set" ng-if="User.signin_failed">
                     用户名或密码错误
                 </div>
              </div>
              
              <button type="submit" class="primary" ng-disabled="signin_form.username.$error.required || signin_form.password.$error.required">登录</button>
          </form>
        </div>
    </div>
    </script>

    <script type="text/ng-template" id="register.tpl">
    <div class="register container signup" ng-controller="SignupController">
        <div class="card">
          <h1>注册</h1>
          <form ng-submit="User.signup()" name="signup_form">
              <div class="input-group">
                 <label>用户名:</label>
                 <input type="text" ng-model="User.signup_data.username" name="username" ng-minlength="4" ng-maxlength="16" ng-model-options="{debounce:500}"  required>
                 <div class="input-error-set" ng-if="signup_form.username.$touched">
                     <div ng-if="signup_form.username.$error.required">用户名为必填项</div>
                     <div ng-if="signup_form.username.$error.minlength || signup_form.username.$error.maxlength">用户名长度需在4到16位之间</div>
                     <div ng-if="User.signup_username_exists">用户名已存在</div>
                 </div>
              </div>
              <div class="input-group">
                 <label>密码:</label>
                 <input type="password" ng-model="User.signup_data.password" name="password" ng-minlength="6" ng-maxlength="25"  required>
                 <div class="input-error-set" ng-if="signup_form.password.$touched">
                     <div ng-if="signup_form.password.$error.required">密码为必填项</div>
                     <div ng-if="signup_form.password.$error.minlength || signup_form.password.$error.maxlength">密码长度需在4到25位之间</div>
                 </div>
              </div>
              
              <button type="submit"  class="primary" ng-disabled="signup_form.$invalid">注册</button>
          </form>
        </div>
    </div>
    </script>

    <script type="text/ng-template" id="question.add.tpl">
    <div class="question_add container" ng-controller="QuestionController">
        <div class="card">
            <form ng-submit="Question.addQuestion()" name="questionadd">
                <div class="input-group">
                  <label>问题标题</label>
                  <input type="text" name="title" ng-model="Question.new_question.title" ng-minlength="5" ng-maxlength="255" required>
                </div>
                <div class="input-group">
                  <label>问题描述</label>
                  <textarea name="desc" ng-model="Question.new_question.desc"></textarea>
                </div>
                <div class="input-group">
                  <button type="submit" ng-disabled="questionadd.$invalid" class="primary">提交</button>
                </div>
            </form>
        </div>
    </div>
    </script>

</html>
