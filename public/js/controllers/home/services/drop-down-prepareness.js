ktur.service("DropDown", [function() {
    this.prepareDropDown = function(scope, http) {
        http({
            method: "GET",
            url: "/drop-down-lists"
        }).then(function successCallback(response) {
            scope.resourcesForTamplate = response.data;
        }, function errorCallback(response) {
            console.log("error");
        })
    }
}]);