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
            templateUrl:'home.tpl'
        });
        $stateProvider.state('login',{
            url:'/login',
            templateUrl:'login.tpl'
        });
        $stateProvider.state('register',{
            url:'/register',
            templateUrl:'register.tpl'
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
    .service('QuestionService',['$http',function($http){
       var me = this;     
       me.go_add_question = function(){
           $state.go('Question.add');
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
    
})();