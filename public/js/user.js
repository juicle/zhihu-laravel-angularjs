(function(){
  'use strict'
  angular.module('user',['answer','question'])
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
        me.getInfo = function(param){
            $http.post('api/user/info',param)
                 .then(function(r){
                     console.log(r);
                    if(r.data.status){
                        if(param.id == "self"){
                          me.self_data = r.data.data; 
                        }else{
                           me.data[param.id] = r.data.data;  
                        }
                        
                    }
                 },function(e){
                     console.log('e',e);
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

    .controller('UserController',['$scope','UserService','$stateParams','AnswerService','QuestionService',function($scope,UserService,$stateParams,AnswerService,QuestionService){
        $scope.User = UserService;
        UserService.getInfo($stateParams);
        AnswerService.getInfo({user_id:$stateParams.id})
          .then(function(r){
              if(r){
                 UserService.his_answers = r;
              } 
          });
       QuestionService.getInfo({user_id:$stateParams.id})
          .then(function(r){
              if(r){
                 UserService.his_questions = r;
              } 
          });   
    }])
})();