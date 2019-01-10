ktur.controller("UserStatementsCtrl", ['UserStatementsRendering', '$scope', '$http', 
function(UserStatementsRendering, $scope, $http) {
    $http({
        method : "POST",
        url : window.location.href + "/statements-data",
        // soon will be changed to dynamic data transver
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