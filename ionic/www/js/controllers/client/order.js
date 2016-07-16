angular.module('starter.controllers')
    .controller('ClientOrderCtrl',[
                '$scope',
                '$state',
                '$ionicLoading',
                'ClientOrder',
                '$ionicActionSheet',
                '$timeout',
        function($scope,$state,$ionicLoading,ClientOrder,$ionicActionSheet,$timeout) {

            var page = 1;

            $scope.items = [];

            $scope.canMoreItems = true;


            //
            //$ionicLoading.show({
            //    template: 'Carregando...'
            //});


            $scope.doRefresh = function(){
                //getOrders().then(function (data) {
                //    $scope.items = data.data;
                //    $scope.$broadcast('scroll.refreshComplete');
                //}, function () {
                //    $scope.$broadcast('scroll.refreshComplete');
                //});

                page = 1;
                $scope.items = [];
                $scope.canMoreItems = true;
                $scope.loadMore();

                $timeout(function(){
                    $scope.$broadcast('scroll.refreshComplete');
                },200);
            };

            $scope.openOrderDetail = function(order){

                $state.go('client.view_order',{id : order.id});
            };


            $scope.showActionSheet = function(order){
                $ionicActionSheet.show({
                    buttons : [
                        {text : 'Ver Detalhes'},
                        {text : 'Ver Entrega'}
                    ],
                    tittleText : 'O que fazer?',
                    cancelText : 'Cancelar',
                    cancel : function(){

                    },
                    buttonClicked : function(index){
                        switch (index){
                            case 0 :
                                $state.go('client.view_order',{id : order.id});
                                break;
                            case 1 :
                                $state.go('client.view_delivery',{id : order.id});
                                break;
                        }
                    }

                });
            };




            $scope.loadMore = function(){       
                getOrders().then(function(data){
                    $scope.items = $scope.items.concat(data.data);

                    if ($scope.items.length == data.meta.pagination.total){
                        $scope.canMoreItems = false;
                    }

                    page += 1;




                    $scope.$broadcast('scroll.infiniteScrollComplete');
                });
            };

            /**
             * a ordenacao eh um recurso do l5-repository
             * do PushCriteria do repository
             */

            function getOrders() {
                return ClientOrder.query({
                    id: null,
                    page : page,
                    orderBy: 'created_at',
                    sortedBy: 'desc'
                }).$promise;
            };

            //nao precisa, pois o loadMore resolve e sera chamado ao entrar na tela
            //getOrders().then(function (data) {
            //        $scope.items = data.data;
            //
            //        $ionicLoading.hide();
            //    }, function () {
            //        $ionicLoading.hide();
            //});



        }]);