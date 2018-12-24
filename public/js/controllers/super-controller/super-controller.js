ktur.controller("SuperController", ['$scope', 'Star', 'Basket',function($scope, Star, Basket) {
    // define star function
    Star.giveAStar($scope);
    Basket.addToBasket($scope);
}]);