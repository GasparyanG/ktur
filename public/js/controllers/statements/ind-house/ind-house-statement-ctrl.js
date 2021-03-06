ktur.controller("IndHouseStatementCtrl", ['$scope', '$http', 'IndHouseFactory', 'SimilarStatements', 'ActorsResourceAdder', "IteratorOfIndHouse",
function($scope, $http, IndHouseFactory, SimilarStatements, ActorsResourceAdder, IteratorOfIndHouse) {
    $http({
        method : "GET",
        url : window.location.href + "/resources"
    }).then(function sucessCalback(response) {
        IndHouseFactory.populateView(response.data, $scope);
        IteratorOfIndHouse.enlargeImage(response.data, $scope);
        SimilarStatements.display(response.data, $scope)
        console.log(response.data);
    }, function errorCallback(response) {
        console.log("error");
    });

    $http({
        method: "GET",
        url: window.location.href + "/action-resources"
    }).then(function successCallback(response) {
        ActorsResourceAdder.addRecources(response.data);
        console.log(response.data);
    }, function errorCallback(response) {
        console.log("error");
    });
}]);