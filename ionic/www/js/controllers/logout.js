angular.module('starter.controllers')
    .controller('logoutCtrl',[
        '$scope',
        '$state',
        '$auth',
        function($scope, $state,$auth){
            $auth.logout();
            $state.go('login');
        }]);