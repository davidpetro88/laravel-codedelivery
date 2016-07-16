angular.module('starter.controllers')

    .controller('ClientViewDeliveryCtrl',[
        '$scope',
        '$stateParams',
        'ClientOrder',
        '$ionicLoading',
        'UserData',
        '$ionicPopup',
        '$pusher',
        '$window',
        '$map',
        'uiGmapGoogleMapApi',
        function($scope,
                 $stateParams,
                 ClientOrder,
                 $ionicLoading,
                 UserData,
                 $ionicPopup,
                 $pusher,
                 $window,
                 $map,
                 uiGmapGoogleMapApi){

            var iconUrl = 'http://maps.google.com/mapfiles/kml/pal2/';

            $scope.order = [];
            $scope.markers = [];
            $scope.map = $map;

            $ionicLoading.show({
                template: 'Carregando...'
            });

            uiGmapGoogleMapApi.then(function(maps){
                $ionicLoading.hide();
            },function(error){
                $ionicLoading.hide();
            });

            ClientOrder.get({id : $stateParams.id, include : 'items,cupom'},function(data){
                $scope.order = data.data;

                if (parseInt($scope.order.status,10) == 1){
                    initMarkers($scope.order);
                } else {
                    $ionicPopup.alert({
                        title : 'Alerta',
                        template: 'Pedido nao esta em status de entrega.'
                    });
                }
            });


            $scope.$watch('markers.length',function(value){
                if (value == 2){
                    createBounds();
                }
            });


            function initMarkers(order){
                var client = UserData.get().client.data;
                var address = client.zipcode + ', '+
                    client.address + ', ' +
                    client.city + ' - '+
                    client.state;

                address='91240090, Jardim Leopoldina,955, Porto Alegre - Rio Grande do Sul';

                createMarkerClient(address);
                watchPositionDeliveryman(order.hash);
            }

            function createMarkerClient(address){
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({
                    address : address
                },function(results, status){
                    if (status == google.maps.GeocoderStatus.OK){
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();

                        $scope.markers.push({
                            id : 'client',
                            coords : {
                                latitude : lat,
                                longitude : lng
                            },
                            options:{
                                title : 'Local de entrega',
                                icon : iconUrl+'icon2.png'
                            }
                        });

                    } else {
                        $ionicPopup.alert({
                            title : 'Alerta',
                            template: 'Não foi possível encontrar seu endereco.'
                        });
                    }
                });
            };

            function watchPositionDeliveryman(channel){
                var pusher = $pusher($window.client);

                var channel = pusher.subscribe(channel);


                channel.bind('CodeDelivery\\Events\\GetLocationDeliveryman',function(data){

                    var lat = data.geo.lat, long = data.geo.long;

                    if ($scope.markers.length <= 1){
                        $scope.markers.push({
                            id : 'entregador',
                            coords : {
                                latitude : lat,
                                longitude : long
                            },
                            options:{
                                title : 'Entregador',
                                icon : iconUrl+'icon47.png'
                            }
                        });

                        return;
                    }

                    //procura pelo marker do entregador para mudar a posicao dele
                    for(var key in $scope.markers){
                        if ($scope.markers[key].id == 'entregador'){
                            $scope.markers[key].coords = {
                                latitude : lat,
                                longitude : long
                            }
                        }
                    }

                });
            }

            function createBounds(){
                var bounds = new google.maps.LatLngBounds();
                var latlng;

                angular.forEach($scope.markers,function(value){
                    latlng = new google.maps.LatLng(Number(value.coords.latitude),Number(value.coords.longitude));
                    bounds.extend(latlng);
                });

                $scope.map.bounds = {
                    northeast :{
                        latitude : bounds.getNorthEast().lat(),
                        longitude : bounds.getNorthEast().lng()
                    },
                    southwest : {
                        latitude : bounds.getSouthWest().lat(),
                        longitude : bounds.getSouthWest().lng()
                    }
                };
            }

        }])
    .controller('CvdControlDescentralize',['$scope','$map',function($scope,$map){
        $scope.map = $map;
        $scope.fit = function(){
            $scope.map.fit = !$scope.map.fit;
        };

    }])
    .controller('CvdControlReaload',['$scope','$window','$timeout',function($scope,$window,$timeout){
        $scope.reload = function(){
            $timeout(function(){
                $window.location.reload(true);
            },100);
        };
    }]);