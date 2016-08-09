angular.module('starter.controllers')
    .controller('loginCtrl',['$scope', '$auth', '$cordovaTouchID', '$cordovaKeychain', '$ionicPopup',
        function ($scope, $auth, $cordovaTouchID, $cordovaKeychain, $ionicPopup) {

            $scope.isSupportTouchID = false;
            $scope.user = { username : '', password : '' };

            $scope.login = function(){
                $auth.login($scope.user.username, $scope.user.password);
            };

            $scope.loginWithTouchID = function () {
                if($scope.isSupportTouchID){
                    $cordovaTouchID.authenticate("Passe o dedo para autenticar").then(function() {
                    var promise = $cordovaKeychain.getForKey('username', 'codedelivery'), username = null;
                        promise
                            .then(function (value) {
                                username = value;
                                return $cordovaKeychain.getForKey('password', 'codedelivery');
                            })
                            .then(function (value) {
                                $auth.login(username, value);
                            });
                    }, function () {
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Login e/ou senha inválidos'
                        });
                    });
                }
            }

            if (ionic.Platform.isWebView() && ionic.Platform.isIOS() && ionic.Platform.isIPad() ){
                $cordovaTouchID.checkSupport().then(function() {
                    $scope.isSupportTouchID = true;
                });
            }
        }]);