angular.module('starter.controllers')
    .controller('TouchIDCtrl',['$scope', 'UserData', 'OAuth', '$ionicPopup',
        function ($scope, UserData, OAuth, $ionicPopup) {

            $scope.user = { username: UserData.get().email, password: ''};

            $scope.login = function () {
                $scope.user.username =UserData.get().email;
                var promisse = OAuth.getAccessToken($scope.user);
                promisse
                    .then(function(){
                        return $cordovaKeychain.getForKey('username', 'codedelivery', $scope.user.username);
                    }
                    .then(function (value) {
                        return $cordovaKeychain.getForKey('password', 'codedelivery', $scope.user.password);
                    })
                    .then(function () {
                        $ionicPopup.alert({
                            title: 'Informação',
                            template: 'TouchID Habilitado'
                        });
                    }),function () {
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Login e/ou senha inválidos'
                        });
                    });
            };


        }]);