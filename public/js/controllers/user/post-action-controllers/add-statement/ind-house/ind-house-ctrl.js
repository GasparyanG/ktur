ktur.controller("IndHouseCtrl", ['$scope', '$http', function($scope, $http) {
    $scope.submit = function() {
        $http({
            method : "POST",
            // "/{user-name}/statement-addition"
            url : window.location.href,
            data: {
                "independent-house" : {
                    // include all fields that need to be validated!
                    'buildingArea' : $scope.buildingArea,
                    'floorAmount' : $scope.floorAmount,
                    'price' : $scope.price,
                    'yardArea' : $scope.yardArea,
                    'rentSell' : $scope.rentSell
                }
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function successCallback(response) {
            // show this errors to users
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        });
    }
}]);