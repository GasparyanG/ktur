ktur.service("QueryStringPreparer", [function() {
    this.defaultOffSetsQueryString = "?ind-house-offset=0&filter=advanced-search"

    this.prepareQueryString = function(scope) {
        var queryString = "&location=" + scope.location +
        "&rentSell=" + scope.rentSell +
        "&min_price=" + scope.min_price +
        "&max_price=" + scope.max_price;

        return queryString;
    }

    this.getDefaultQueryString = function() {
        return this.defaultOffSetsQueryString;
    }
}]);