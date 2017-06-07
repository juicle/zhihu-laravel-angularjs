(function(){
  'use strict'
  angular.module('question',[])
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
       me.getInfo = function(params){
          return $http.post('api/question/read',params)
                 .then(function(r){
                   console.log(r)
                   if(r.data.status){
                     me.data = angular.merge({},me.data,r.data.data);   
                     return r.data.data;
                   }
                   return false;
                 });  
        }
    }])
    .controller('QuestionController',['$scope','QuestionService',function($scope,QuestionService){
        $scope.Question = QuestionService;
    }])
})();