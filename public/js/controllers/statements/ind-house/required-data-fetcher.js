ktur.service("DataFetcher", [function() {
    this.fetchRequiredData = function(jsonObject) {
        return jsonObject["requred_data"];
    }

    this.fetchLocation = function(jsonObject) {
        var requiredData = this.fetchRequiredData(jsonObject);
        
        return requiredData["location"];
    }

    this.fetchOptionOver = function(jsonObject) {
        var requiredData = this.fetchRequiredData(jsonObject);

        return requiredData["option_over"];
    }

    this.fetchPrice = function(jsonObject) {
        var requiredData = this.fetchRequiredData(jsonObject);

        return requiredData["price"];
    }
}]);