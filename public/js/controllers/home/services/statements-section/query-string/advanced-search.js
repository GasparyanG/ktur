ktur.service("AdvancedSearch", ["UserStatementsRendering", "Cleaner", "QueryStringPreparer", "ErrorsDisplayer",
function(UserStatementsRendering, Cleaner, QueryStringPreparer, ErrorsDisplayer) {
    this.setAdvancedSearch = function(scope, http) {
        scope.getStatements = function() {
            var queryString = QueryStringPreparer.prepareQueryString(scope);
            var d_url = "/home/statement-resources" + QueryStringPreparer.getDefaultQueryString() + queryString;

            Cleaner.cleanAll();
            // if any
            Cleaner.cleanAllErrors();

            http({
                method: "GET",
                url: d_url
            }).then(function successCallback(response) {
                if (response.data["errors"]) {
                    ErrorsDisplayer.displayErrors(response.data["errors"]);
                }
                UserStatementsRendering.renderUserStatements(response.data, scope);
                console.log(response.data);
            }, function errorCallback(response) {
                console.log("error");
            })
        }
    }
}]);