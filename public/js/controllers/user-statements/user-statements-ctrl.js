ktur.controller("UserStatementsCtrl", ['$scope', '$http', function($scope, $http) {
    $http({
        method : "GET",
        url : window.location.href + "/statements-data"
    }).then(function successCallback(response) {
        console.log(response.data);
    }, function errorCallback(response) {
        console.log("error");
    });
}]);