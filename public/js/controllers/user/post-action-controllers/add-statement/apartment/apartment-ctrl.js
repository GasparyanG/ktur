ktur.controller("ApartmentCtrl", ['$scope', function($scope) {
    $scope.submit = function() {
        console.log($scope.location);
        console.log($scope.buildingArea);
    }
}]);