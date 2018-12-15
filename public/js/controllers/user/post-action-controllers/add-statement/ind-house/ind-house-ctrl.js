ktur.controller("IndHouseCtrl", ['$scope', '$http','SelectHandler', function($scope, $http, SelectHandler) {
    // change select tag's default option's value and textcontent
    SelectHandler.setLocationOptionAsSelected();
    SelectHandler.setRentSellOptionAsSelected();

    // XHR request to server PostAction object
    $scope.submit = function() {
        $http({
            method : "POST",
            // "/{user-name}/statement-addition"
            url : window.location.href,
            data: {
                // for table creation this key is very important
                "independent-house" : {
                    // include all fields that need to be validated!
                    'buildingArea' : $scope.buildingArea,
                    'floorAmount' : $scope.floorAmount,
                    'price' : $scope.price,
                    'yardArea' : $scope.yardArea,
                    'statementTextArea' : $scope.statementTextArea,
                    'rentSell' : $scope.rentSell ? $scope.rentSell : 0,
                    'location' : $scope.location ? $scope.location : 0,
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