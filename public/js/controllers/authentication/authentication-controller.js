ktur.controller("AuthenticationController", ['$scope', '$http', 'ErrorHighlighter', 'FormValidator', 
    function($scope, $http, ErrorHighlighter, FormValidator) {
    $scope.signUp =  function() {
        /**
         * this will check to see whether all fealds of input is filled:
         * if yes:
         *      return true
         * else:
         *      none
         */
        if (FormValidator.validateInput($scope)) {
            $http({
            method: "POST",
            url: "/sign-up",
            data: {
                'first_name' : $scope.first_name,
                "last_name" : $scope.last_name,
                "username" : $scope.username,
                "password" : $scope.password
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function successsCallback(response) {
            var inputFealds = {
                'first_name' : $scope.first_name,
                "last_name" : $scope.last_name,
                "username" : $scope.username,
                "password" : $scope.password
            }
            
            ErrorHighlighter.heighlightErrors(response.data);
            
        }, function errorCallback(response) {
            console.log('error');
        });
    };
    }
}])