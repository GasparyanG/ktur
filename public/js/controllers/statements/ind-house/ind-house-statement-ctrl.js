ktur.controller("IndHouseStatementCtrl", ['$scope', '$http', 'IndHouseFactory', function($scope, $http, IndHouseFactory) {
    $http({
        method : "GET",
        url : window.location.href + "/resources"
    }).then(function sucessCalback(response) {
        IndHouseFactory.populateView(response.data, $scope);
        console.log(response.data);
    }, function errorCallback(response) {
        console.log("error");
    })
}]);