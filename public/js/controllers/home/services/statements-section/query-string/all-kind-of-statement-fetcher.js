ktur.service("AllFetcher", ["UserStatementsRendering", function(UserStatementsRendering) {
    this.getAllStatements = function(http, scope) {
        http({
            method: "GET",
            url: "home/statement-resources" + 
            "?ind-house-offset=0"
        }).then(function successCallback(response) {
            UserStatementsRendering.renderUserStatements(response.data, scope);
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        })
    }
}]);