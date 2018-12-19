ktur.controller("SuperController", ['$scope', 'Star', function($scope, Star) {
    // define star function
    Star.giveAStar($scope);
}]);