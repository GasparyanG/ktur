ktur.controller('NavBarController', ['$scope', '$http', 'FactoryForNavBar', function($scope, $http, FactoryForNavBar) {
    $http({
        method: "GET",
        url: "/nav-bar"

    }).then(function sucessCalback(response) {
        console.log(response.data);
        FactoryForNavBar.create(response.data);
    }, function errorCallback(response) {
        console.log("error");
    });
}]);