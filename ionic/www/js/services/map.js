angular.module('starter.services')
    .factory('$map',function(){
        return {
            center : {
                latitude : 0,
                longitude : 0
            },
            pan: true,
            zoom : 12
        };
    });