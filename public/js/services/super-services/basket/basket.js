ktur.service("Basket", ["$http", "ResponsiveBasket", 
function($http, ResponsiveBasket) {
    this.addToBasket = function(scope) {
        scope.basket = function(url) {
            $http({
                method: "POST",
                url: url
            }).then(function sucessCallback(response) {
                // this must be not outputed!
                console.log(response.data);
                if (response.data === "redirect") {
                    window.location.href = "/sign-up";
                }

                else if (response.data === "forked") {
                    ResponsiveBasket.fork(url);
                }
            }, function errorCallback(response) {
                console.log("error")
            })
        }
    }
}]);