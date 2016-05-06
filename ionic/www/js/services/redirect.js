angular.module('starter.services')
    .service('$redirect',['$state','UserData','appConfig',function($state,UserData,appConfig){
        this.redirectAfterLogin = function(){
            var user = UserData.get();
            //console.log(appConfig.redirectAfterLogin[user.role]);
            //$state.go(appConfig.redirectAfterLogin['client']);
            $state.go('client.order');
        };
    }]);