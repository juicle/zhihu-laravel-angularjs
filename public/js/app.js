(function(){
  'use strict'
  angular.module('zhihu',[
      'ui.router',
      'common',
      'user',
      'question',
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
        $stateProvider.state('question',{
            abstract:true,
            url:'/question',
            template:'<div ui-view></div>'
        }).state('question.add',{
            url:'/add',
            templateUrl:'tpl/page/question_add'
        });
        
    })
    .controller('HomeController',['$scope','TimelineService',function($scope,TimelineService){
        var $win;
        $scope.TimeLine = TimelineService;
        TimelineService.get();


        
        $win = $(window);
        $win.on('scroll',function(){
          if($win.scrollTop() - ($(document).height() - $win.height()) > -30){
            TimelineService.get();
          }
        });
    }])
    
})();