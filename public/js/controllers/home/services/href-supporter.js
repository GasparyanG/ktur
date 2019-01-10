ktur.service("HrefSupporter", [function() {
    this.getHrefs = function(http) {
        http({
            method: "GET",
            url: window.location.href + "/hrefs"
        }).then(function successCallback(response) {
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        });
    }
}]);