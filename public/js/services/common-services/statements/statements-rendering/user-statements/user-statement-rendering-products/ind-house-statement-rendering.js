ktur.service("IndHouseStatementRendering", ["StatementBoxComposer", function(StatementBoxComposer) {
    this.isUsed = function(statementType) {
        return statementType === "ind_house";
    }

    this.execute = function(arrayToFetchDataFrom, scope) {
        var indHouseSection = document.getElementById("ind_house");

        for (var i = 0; i < arrayToFetchDataFrom.length; i++) {
            // create fully populated statement box and return
            var statementBox = StatementBoxComposer.compose(arrayToFetchDataFrom[i], scope);
            indHouseSection.appendChild(statementBox);
        }
    }
}]);