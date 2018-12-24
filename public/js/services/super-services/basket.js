ktur.service("Basket", ["$http", function($http) {
    this.addToBasket = function(scope) {
        scope.basket = function(url) {
            $http({
                method: "POST",
                url: url
            }).then(function sucessCallback(response) {
                // this must be not outputed!
                console.log(response.data);
            }, function errorCallback(response) {
                console.log("error")
            })
        }
    }
}]);