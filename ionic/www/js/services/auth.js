angular.module('starter.services')
    .service('$auth', ['OAuth', 'OAuthToken', 'UserData', 'User', '$ionicHistory', '$ionicPopup', '$ionicLoading', '$localStorage', '$redirect',
        function (OAuth, OAuthToken, UserData, User, $ionicHistory, $ionicPopup, $ionicLoading, $localStorage, $redirect) {

            this.login = function (username, password) {
                $ionicLoading.show({ template: 'Aguarde...' });

                var promisse = OAuth.getAccessToken({username: username, password: password });
                promisse
                    .then(function(data) {
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

                // var promisse = OAuth.getAccessToken({username: username, password: password});
            };
            this.logout = function () {
                OAuthToken.removeToken();
                UserData.set(null);
                $ionicHistory.clearCache();
                $ionicHistory.clearHistory();
                $ionicHistory.nextViewOptions({
                    disableBack: true,
                    historyRoot: true
                });
            }
        }]);