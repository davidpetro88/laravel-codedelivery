angular.module('starter.controllers')
    .controller('ClientMenuCtrl',[
        '$scope',
        '$state',
        '$ionicLoading',
        'UserData',
        function($scope,$state,$ionicLoading,UserData){

            $scope.user = UserData.get();

            $scope.logout = function(){
                $state.go('logout');
            };

        }]);