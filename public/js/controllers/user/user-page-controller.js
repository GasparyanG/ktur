ktur.controller('UserPageController', ['$scope', '$http', 'Factory', function($scope, $http, Factory){
    $http({
        
        method: "GET",
        url: window.location.href + "/resources",
    
    }).then(function successCallback(response) {
        var dataAboutUser = response.data['user'];
        for (var i = 0; i < dataAboutUser.length; i++) {
            Factory.create(dataAboutUser[i]);
        }

    }, function errorCallback(response){
        console.log("error")
    });
}]);