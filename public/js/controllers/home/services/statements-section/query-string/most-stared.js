ktur.service("MostStared", ["UserStatementsRendering", "Cleaner", function(UserStatementsRendering, Cleaner) {
    this.setButtonToReturnMostStared = function(scope, http) {
        scope.moreStared = function() {
            Cleaner.cleanAll();
            
            http({
                method: "GET",
                url: "home/statement-resources" + 
                "?ind-house-offset=0&filter=most-stared"
            }).then(function successCalllback(response) {
                UserStatementsRendering.renderUserStatements(response.data, scope);
                console.log(response.data);
            }, function errorCallback(response) {
                console.log("error");
            })
        }
    }
}]);