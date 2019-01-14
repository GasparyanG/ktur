ktur.service("SimilarStatements", ["$http", 'DataFetcher', 'IndHouseStatementRendering', 
function($http, DataFetcher, IndHouseStatementRendering) {
    this.display = function(requiredData, scope) {
        var d_url = this.createUrl(requiredData);

        $http({
            method: "GET",
            url: d_url
        }).then(function successCallback(response) {
            var arrayToFetchDataFrom = response.data["ind_house"];
            IndHouseStatementRendering.execute(arrayToFetchDataFrom, scope);
            console.log(response.data)
        }, function errorCallback(response) {
            console.log("error");
        })
    }

    this.createUrl = function(requiredData, scope) {
        var fullUrl = "";
        // urlPath
        fullUrl += "/home/statement-resources";
        // offsets
        fullUrl += "?ind-house-offset=0";
        // filters
        // location
        var location = DataFetcher.fetchLocation(requiredData);
        fullUrl += "&location=" + location;
        //rentSell
        var rentSell = DataFetcher.fetchOptionOver(requiredData);
        fullUrl += "&rentSell=" + rentSell;
        // minPrice
        var price = DataFetcher.fetchPrice(requiredData);
        var minPirce = this.calcMinPrice(price);
        fullUrl += "&min_price=" + minPirce;
        // maxPrice
        var maxPrice = this.calcMaxPrice(price);
        fullUrl += "&max_price=" + maxPrice;

        return fullUrl;
    }

    this.calcMinPrice = function(price)
    {
        return price / 2;
    }

    this.calcMaxPrice = function(price)
    {
        return price;
    }
}]);