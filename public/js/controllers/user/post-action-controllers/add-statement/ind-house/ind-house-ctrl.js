ktur.controller("IndHouseCtrl", ['$scope', function($scope) {
    $scope.submit = function() {
        console.log($scope.location);
        console.log($scope.buildingArea);
        console.log($scope.rentSell);
    }
}]);