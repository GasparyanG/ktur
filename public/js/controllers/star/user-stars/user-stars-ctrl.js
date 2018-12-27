ktur.controller("UserStarsCtrl", ['$scope', '$http', function($scope, $http) {
    $http({
        method: "POST",
        url: window.location.href + "/user-statements-stars",
        
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
    }, function errorCallback(response) {
        console.log("error");
    });
}]);