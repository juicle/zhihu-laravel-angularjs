(function(){
  'use strict'
  angular.module('zhihu',[
      'ui.router',
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
            templateUrl:'question.add.tpl'
        });
        
    })

    .service('UserService', ['$http','$state',function($http,$state){
        var me = this;
        me.signup_data = {};
        me.signin_data = {};
        me.signup = function(){
            $http.post('/api/signup',me.signup_data)
                 .then(function(r){
                    //console.log('r',r);
                     if(r.data.status){
                       me.signup_data = {};   
                       $state.go('login');
                     }
                 },function(e){
                     console.log('e',e);
                 });
            
        }
        
        me.username_exists = function(){
            $http.post('/api/user/exists',{username:me.signup_data.username})
                 .then(function(r){
                     //console.log('r',r);
                     if(r.data.status&&r.data.data.count>0){
                         me.signup_username_exists = true;
                     }else{
                         me.signup_username_exists = false;
                     }
                 },function(e){
                     console.log('e',e);
                 });
        }
        me.signin = function(){
            $http.post('/api/signin',me.signin_data)
                 .then(function(r){
                    //console.log('r',r);
                     if(r.data.status){ 
                       location.href = "/";
                     }else{
                       me.signin_failed = true;
                     }
                 },function(e){
                     console.log('e',e);
                 });
        }
    }])
    .service('QuestionService',['$http','$state',function($http,$state){
       var me = this;     
       me.new_question = {};
       me.go_add_question = function(){
           $state.go('question.add');
       }
       me.addQuestion = function(){
           if(!me.new_question.title)
             return;
           $http.post('/api/question/create',me.new_question)
                 .then(function(r){
                    //console.log('r',r);
                     if(r.data.status){ 
                       me.new_question= {};
                       $state.go('home');
                     }else{
                       me.signin_failed = true;
                     }
                 },function(e){
                     console.log('e',e);
                 });
       }
    }])
    .service('TimelineService',['$http','$state',function($http,$state){
       var me = this;     
       me.data = [];
       me.currentpage = 1;
       me.get = function(conf){
           if (me.pedding) return;
           
           conf = conf || {page:me.currentpage};
           if(!me.nomoredata){
             me.pedding = true;
           }
           $http.post('api/timeline',conf)
                 .then(function(r){
                    //console.log('r',r);
                     if(r.data.status){ 
                       if(r.data.data.length){
                         me.data= me.data.concat(r.data.data);
                         me.currentpage ++;
                       }else{
                         me.nomoredata = true;
                       }
                       
                     }else{
                       console.log('network error');
                     }
                 },function(e){
                     console.log('network error');
                 })
                 .finally(function(e){
                     me.pedding = false;
                    
                 });
       }
    }])
    .controller('SignupController',['$scope','UserService',function($scope,UserService){
        $scope.User = UserService;
        $scope.$watch(function(){
            return UserService.signup_data;
        },function(n,o){
            if(n.username!=o.username){
               UserService.username_exists();
            }
        },true);
    }])
    .controller('SigninController',['$scope','UserService',function($scope,UserService){
        $scope.User = UserService;
    }])
    .controller('QuestionController',['$scope','QuestionService',function($scope,QuestionService){
        $scope.Question = QuestionService;
    }])
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