ktur.service("Star", ['$http', function($http) {
    this.giveAStar = function(scope) {
        scope.star = function(url) {
            $http({
                method : "POST",
                url : url
            }).then(function successCallbck(response) {
                console.log(response.data);
                if (response.data === "redirect") {
                    window.location.href = "/sign-up";
                }
            }, function errorCallback(response) {
                console.log("error");
            });
        }
    }
}]);