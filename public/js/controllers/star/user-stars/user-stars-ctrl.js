ktur.controller("UserStarsCtrl", ['$scope', '$http', 'StatementsStarsRepresentation', 'SeeStars',
function($scope, $http, StatementsStarsRepresentation, SeeStars) {
    SeeStars.seeStars($scope);

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
        // scope will be used in '$compile' service
        StatementsStarsRepresentation.render(response.data, $scope);
    }, function errorCallback(response) {
        console.log("error");
    });
}]);