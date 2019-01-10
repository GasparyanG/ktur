ktur.service("SeeStars", ['$http', 'StaredUsersRendering',function($http, StaredUsersRendering) {
    this.seeStars = function(scope) {
        scope.seeStars = function(url) {
            $http({
                method: "POST",
                url: url,

                data : {
                    // soon this will be dynamic !
                    "statementOffsets" : 0
                },

                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                }
            }).then(function successCallback(response) {
                console.log(response.data);
                StaredUsersRendering.showStaredUsers(response.data, url);
            }, function errorCallback(response) {
                console.log("error");
            });
        }
    }
}]);