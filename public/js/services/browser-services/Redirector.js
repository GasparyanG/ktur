ktur.service('Redirector', [function() {
    this.config = {
        "redirect" : "redirection",
    }
    this.isRedirectable = function(jsonFromServer) {
        for(var key in jsonFromServer) {
            if (key === this.config["redirect"]) {
                var pathToRedirect = jsonFromServer[key];
                return pathToRedirect;
            }
        }

        return false;
    }

    this.redirect = function(pathToRedirect) {
        location.assign(pathToRedirect);
    }
}]);