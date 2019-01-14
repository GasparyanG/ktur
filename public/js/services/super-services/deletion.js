ktur.service('Deletion', ['$http', function($http) {
    this.removeFromDB = function(scope) {
        scope.deleteStatement = function(url) {
            // this need to be separated
            var elements = document.getElementsByClassName(url);
            elements[0].parentNode.parentNode.remove()

            $http({
                method: "POST",
                url: url
            }).then(function successCallback(response) {
                console.log(response.data);
            }, function errorCallback(response) {
                console.log("error");
            });
        }
    }
}]);