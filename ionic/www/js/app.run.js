angular.module('starter.run').run([
    '$state','PermissionStore', 'RoleStore', 'OAuth','UserData','$rootScope','authService','httpBuffer',
    function($state,PermissionStore,RoleStore,OAuth,UserData,$rootScope,authService,httpBuffer){
        PermissionStore.definePermission('user-permission',function(){
            return OAuth.isAuthenticated();
        });


        /**
         * Permissoes de cliente
         */
        PermissionStore.definePermission('client-permission',function(){
            var user = UserData.get();

            if (user == null || !user.hasOwnProperty('role')){
                return false;
            }

            return user.role =='client';
        });

        //definindo papel
        RoleStore.defineRole('client-role',['user-permission','client-permission']);

        /**
         * Permissoes de deliveryman
         */

        PermissionStore.definePermission('deliveryman-permission',function(){
            var user = UserData.get();

            if (user == null || !user.hasOwnProperty('role')){
                return false;
            }

            return user.role =='deliveryman';
        });

        //definindo papel
        RoleStore.defineRole('deliveryman-role',['user-permission','deliveryman-permission']);


        $rootScope.$on('event:auth-loginRequired',function(event,data){

            switch (data.data.error){
                case 'access_denied':

                    if (!$rootScope.refreshingToken) {
                        $rootScope.refreshingToken = OAuth.getRefreshToken();
                    }

                    $rootScope.refreshingToken.then(function (data) {
                        authService.loginConfirmed();
                        $rootScope.refreshingToken = null;
                    }, function (responseError) {
                        $state.go('logout');
                    });

                    break;
                case 'invalid_credentials':
                    httpBuffer.rejectAll(data);
                    break;
                default :
                    $state.go('logout');
                    break;
            }

        });

    }]);