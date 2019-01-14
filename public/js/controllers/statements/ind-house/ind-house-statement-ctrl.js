ktur.controller("IndHouseStatementCtrl", ['$scope', '$http', 'IndHouseFactory', 'SimilarStatements',
function($scope, $http, IndHouseFactory, SimilarStatements) {
    $http({
        method : "GET",
        url : window.location.href + "/resources"
    }).then(function sucessCalback(response) {
        IndHouseFactory.populateView(response.data, $scope);
        SimilarStatements.display(response.data, $scope)
        console.log(response.data);
    }, function errorCallback(response) {
        console.log("error");
    })
}]);