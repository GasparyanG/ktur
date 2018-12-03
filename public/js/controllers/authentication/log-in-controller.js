ktur.controller('LogInController', ['$scope', '$http', 'ErrorHighlighter', 'FormValidator',
function($scope, $http, FormValidator, ErrorHighLighter) {
    $scope.logIn = function() {
        // at the end user page will be returned (i mean this smells like 'GET' request),
        // but sent sensative data (password), which is better to be sent with 'POST' method!
        $http({
            method: "POST",
            url: "/log-in",

            data: {
                "username": $scope.username,
                'password': $scope.password,
            },

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function successCallback(response) {
            console.log(response.data);

            // more likely this will return error messages or info usefull for user 

        }, function errorCallback(response) {
            console.log('error');
        });
    }
}])