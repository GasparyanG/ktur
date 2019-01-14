ktur.controller("SuperController", ['$scope', 'Star', 'Basket', 'Deletion', function($scope, Star, Basket, Deletion) {
    // define star function
    Star.giveAStar($scope);
    Basket.addToBasket($scope);
    Deletion.removeFromDB($scope);
}]);