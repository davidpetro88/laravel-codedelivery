angular.module('starter.services')
    .service('$redirect',['$state','UserData','appConfig',function($state,UserData,appConfig){
        this.redirectAfterLogin = function(){
            var user = UserData.get();

            // alert(user.role);
            // alert(user.role+'.order');
            // console.log(user.role);
            // $state.go(user.role+'.order');
            //console.log(appConfig.redirectAfterLogin[user.role]);
            $state.go(appConfig.redirectAfterLogin[user.role]);
            // $state.go('client.order');
        };
    }]);