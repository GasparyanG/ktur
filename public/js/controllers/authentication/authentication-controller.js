ktur.controller("AuthenticationController", ['$scope', '$http', 'ErrorHighlighter', 'FormValidator', 'Redirector',
    function($scope, $http, ErrorHighlighter, FormValidator, Redirector) {
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
        }).then(function successCallback(response) {
            var inputFealds = {
                'first_name' : $scope.first_name,
                "last_name" : $scope.last_name,
                "username" : $scope.username,
                "password" : $scope.password
            }
            
            var pathToResource = Redirector.isRedirectable(response.data);
            if (!pathToResource){
                ErrorHighlighter.heighlightErrors(response.data);
            }
            else {
                Redirector.redirect(pathToResource);
            }
            
        }, function errorCallback(response) {
            console.log('error');
        });
    };
    }
}])