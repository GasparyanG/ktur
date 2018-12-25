ktur.controller("UserBasketCtrl",['$scope', '$http', 'UserStatementsRendering', 
function($scope, $http, UserStatementsRendering) {
    $http({
        method : "POST",
        url : window.location.href + "/user-basket-content",
        
        data : {
            "statementOffsets" : {
                "ind_house" : 0
            },

            "filter" : "regular"
        },

        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        }
    }).then(function successCallback(response) {
        console.log(response.data);
        UserStatementsRendering.renderUserStatements(response.data, $scope);
    }, function errorCallback(response) {
        console.log("error");
    });
}]);