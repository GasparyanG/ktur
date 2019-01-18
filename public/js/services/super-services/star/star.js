ktur.service("Star", ['$http', 'ResponsiveStar', function($http, ResponsiveStar) {
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

                else if (response.data === "stared") {
                    ResponsiveStar.addStar(url);
                }
            }, function errorCallback(response) {
                console.log("error");
            });
        }
    }
}]);