ktur.controller("IndHouseStatementCtrl", ['$scope', '$http', function($scope, $http) {
    $http({
        method : "GET",
        url : window.location.href + "/resources"
    }).then(function sucessCalback(response) {
        console.log(response.data);
    }, function errorCallback(response) {
        console.log("error");
    })
}]);