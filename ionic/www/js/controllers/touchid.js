angular.module('starter.controllers')
    .controller('TouchIDCtrl',['$scope', 'UserData', 'OAuth', '$ionicPopup', '$cordovaKeychain',
        function ($scope, UserData, OAuth, $ionicPopup, $cordovaKeychain) {

            $scope.user = {
                username: UserData.get().email,
                password: ''
            };

            $scope.login = function () {
                $scope.user.username = UserData.get().email;
                var promise = OAuth.getAccessToken($scope.user);
                promise
                    .then(function() {
                        return $cordovaKeychain.setForKey('username', 'codedelivery', $scope.user.username);
                    })
                    .then(function () {
                        return $cordovaKeychain.setForKey('password', 'codedelivery', $scope.user.password);
                    })
                    .then(function () {
                        $ionicPopup.alert({
                            title: 'Informação',
                            template: 'TouchID Habilitado'
                        });
                    },function () {
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Login e/ou senha inválidos'
                        });
                    });
            };
        }]);