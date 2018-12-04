ktur.controller('LogInController', ['$scope', '$http', 'FormValidator', 'ErrorHighlighter', 'Redirector',
function($scope, $http, FormValidator, ErrorHighLighter, Redirector) {
    $scope.logIn = function() {
        // at the end user page will be returned (i mean this smells like 'GET' request),
        // but sent sensative data (password), which is better to be sent with 'POST' method!
        if (FormValidator.validateLogIn($scope)) {
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
                var pathToResource = Redirector.isRedirectable(response.data);
                if (!pathToResource){
                    ErrorHighLighter.heighlightErrors(response.data);
                }
                else {
                    Redirector.redirect(pathToResource);
                }
                
            }, function errorCallback(response) {
                console.log('error');
            });
        }
    }
}])