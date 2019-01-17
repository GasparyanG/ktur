ktur.service("RedirectionUrlPreparer", [function() {
    this.tableNames = {
        "ind_house_statements" : "ind-houses"
    }

    this.prepareRedirectingUrl = function(url) {
        var arrayOfRequredData = this.getTableNameAndUniqeIdentifier(url);

        var statementType = this.getStatementTypeBasedOnTableName(arrayOfRequredData[1]);
        var statementUniqueIdentifier = arrayOfRequredData[2];

        return "/statements/" + statementType + "/" + statementUniqueIdentifier; // + "#comments";
    }

    // /statements/ind_house_statements/13/comment ng-scope
    this.getTableNameAndUniqeIdentifier = function(url) {
        var regExp = new RegExp("/statements/([a-zA-Z0-9_-]+)/([a-zA-Z0-9-_]+)")
        var matches = regExp.exec(url);
        
        return matches;
    }

    this.getStatementTypeBasedOnTableName = function(tableName) {
        return this.tableNames[tableName];
    }
}]);