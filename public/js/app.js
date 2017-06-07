(function(){
  'use strict'
  window.his = {
      id:parseInt($('html').attr('userid'))
  };
  angular.module('zhihu',[
      'ui.router',
      'common',
      'user',
      'question',
      'answer',
  ])
    .config(function($interpolateProvider,$stateProvider,$urlRouterProvider){
        $interpolateProvider.startSymbol('[:');
        $interpolateProvider.endSymbol(':]');
        
        $urlRouterProvider.otherwise('/home');
        $stateProvider.state('home',{
            url:'/home',
            templateUrl:'tpl/page/home'
        });
        $stateProvider.state('login',{
            url:'/login',
            templateUrl:'tpl/page/login'
        });
        $stateProvider.state('register',{
            url:'/register',
            templateUrl:'tpl/page/register'
        });
        $stateProvider.state('user',{
            url:'/user/:id',
            templateUrl:'tpl/page/user'
        });
        $stateProvider.state('question',{
            abstract:true,
            url:'/question',
            template:'<div ui-view></div>'
        }).state('question.add',{
            url:'/add',
            templateUrl:'tpl/page/question_add'
        });
        
    })
    
    
})();