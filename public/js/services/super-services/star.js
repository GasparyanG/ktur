ktur.service("Star", ['$http', function($http) {
    this.giveAStar = function(scope) {
        scope.star = function(url) {
            $http({
                method : "POST",
                url : url
            }).then(function successCallbck(response) {
                console.log(response.data);
            }, function errorCallback(response) {
                console.log("error");
            });
        }
    }
}]);