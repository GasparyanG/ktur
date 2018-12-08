ktur.controller('UserPageController', ['$scope', '$http', 'Factory', 'UrlValidator', 'ElementActivater', 
function($scope, $http, Factory, UrlValidator, ElementActivater){
    var currentUrl = UrlValidator.validateUrlPath(window.location.href);
    
    $scope.heighlight = function(fragment) {
        ElementActivater.activateElement(fragment)
    }

    $http({
        
        method: "GET",
        url: currentUrl + "/resources",
    
    }).then(function successCallback(response) {
        var dataAboutUser = response.data['user'];
        for (var i = 0; i < dataAboutUser.length; i++) {
            Factory.create(dataAboutUser[i]);
        }

    }, function errorCallback(response){
        console.log("error")
    });
}]);