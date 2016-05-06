angular.module('starter.controllers')
    .controller('logoutCtrl',[
        '$scope',
        '$state',
        '$ionicHistory',
        'OAuthToken',
        'UserData',
        function($scope, $state, $ionicHistory, OAuthToken,UserData){
            OAuthToken.removeToken();
            UserData.set(null);

            $ionicHistory.clearCache();
            $ionicHistory.clearHistory();

            $ionicHistory.nextViewOptions({
                disableBack : true,
                historyRoot : true
            });

            $state.go('login');
        }]);