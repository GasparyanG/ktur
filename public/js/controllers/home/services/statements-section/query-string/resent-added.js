ktur.service("ResentAdded", ["UserStatementsRendering", "Cleaner", function(UserStatementsRendering, Cleaner) {
    this.setButtonToReturnResentAdded = function(scope, http) {
        scope.resentAdded = function() {
            Cleaner.cleanAll();

            http({
                method: "GET",
                url: "home/statement-resources" + 
                "?ind-house-offset=0&filter=resent-added"
            }).then(function successCallback(response) {
                UserStatementsRendering.renderUserStatements(response.data, scope);
                console.log(response.data);
            }, function errorCallback(response) {
                console.log('error')
            });
        }
    }
}]);