ktur.service("UserStatementsRendering", ["IndHouseStatementRendering", function(IndHouseStatementRendering) {
    this.products = [
        IndHouseStatementRendering
    ];

    this.renderUserStatements = function(arrayToFetchDataFrom, scope) {
        for(var statementType in arrayToFetchDataFrom) {
            for (var i = 0; i < this.products.length; i++) {
                if (this.products[i].isUsed(statementType)) {
                    this.products[i].execute(arrayToFetchDataFrom[statementType], scope);
                }
            }
        }
    }
}]);