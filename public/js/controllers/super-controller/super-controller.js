ktur.controller("SuperController", ['$scope', 'Star', 'Basket', 'Deletion', 'CommentButtonForRedirection',
function($scope, Star, Basket, Deletion, CommentButtonForRedirection) {
    // define star function
    Star.giveAStar($scope);
    Basket.addToBasket($scope);
    Deletion.removeFromDB($scope);
    console.log(CommentButtonForRedirection);
    CommentButtonForRedirection.activateCommentButton($scope);
}]);