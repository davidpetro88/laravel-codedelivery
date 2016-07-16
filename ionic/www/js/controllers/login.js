angular.module('starter.controllers')
    .controller('loginCtrl',[
        '$scope',
        'OAuth',
        'OAuthToken',
        '$ionicPopup',
        '$state',
        'UserData',
        'User',
        '$localStorage',
        '$ionicLoading',
        '$cordovaNetwork',
        '$redirect',
        function($scope,OAuth,OAuthToken,$ionicPopup,$state,UserData,User,$localStorage,$ionicLoading,$cordovaNetwork,$redirect){

            $scope.user = { username : '', password : ''};
            $scope.login = function(){

            $ionicLoading.show({ template: 'Aguarde...' });
                var promisse = OAuth.getAccessToken($scope.user);
                    promisse.then(function(data) {
                            var token = $localStorage.get('device_token');
                            //return User.updateDeviceToken({},{device_token: token}).$promise;
                        })
                        .then(function(data) {
                            return User.authenticated({include: 'client'}).$promise;
                        })
                        .then(function(data){
                            UserData.set(data.data);
                            $ionicLoading.hide();
                            $redirect.redirectAfterLogin();
                            //if (data.data.role === 'client') {
                            //    $state.go('client.checkout');
                            //} else {
                            //    $state.go('deliveryman.order');
                            //}

                        },function(responseError){
                            $ionicLoading.hide();
                            UserData.set(null);
                            OAuthToken.removeToken();
                            $ionicPopup.alert({
                                title : 'Alerta',
                                template: 'Login e/ou senha inválidos'
                            });
                            console.debug(responseError);
                        });
            };

        }]);