angular.module('starter.controllers')
    .controller('ClientMenuCtrl',[
        '$scope',
        '$state',
        '$ionicLoading',
        'UserData',
        '$cordovaTouchID',
        function($scope,$state,$ionicLoading,UserData,$cordovaTouchID){
            // mudei true para testar
            $scope.isSupportTouchID = true;
            $scope.user = UserData.get();
            $scope.logout = function(){
                $state.go('logout');
            };

            if (ionic.Platform.isWebView() && ionic.Platform.isIOS() && ionic.Platform.isIPad() ){
                $cordovaTouchID.checkSupport().then(function() {
                    $scope.isSupportTouchID = true;
                });
            }

        }]);