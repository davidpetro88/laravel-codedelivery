angular.module('starter.controllers')
    .controller('DeliverymanMenuCtrl',['$scope', '$state', '$ionicLoading', 'UserData', '$cordovaTouchID',
        function($scope,$state,$ionicLoading,UserData, $cordovaTouchID){
            $scope.isSupportTouchID = false;
            $scope.user = UserData.get();
            $scope.logout = function(){
                $state.go('logout');
            }

            if (ionic.Platform.isWebView() && ionic.Platform.isIOS() && ionic.Platform.isIPad() ){
               $cordovaTouchID.checkSupport().then(function() {
                  $scope.isSupportTouchID = true;
               });
            }

        }]);