(function(){
   'use strict'
   angular.module('common',[])
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
})();