ktur.service("SeeStarsHelper", [function() {
    this.arrayOfSeeStarRequests = [];

    this.addToArrayOfRequests = function(url) {
        this.arrayOfSeeStarRequests.push(url);
    }

    this.isRequested = function(url) {
        for (var i = 0; i < this.arrayOfSeeStarRequests.length; i++) {
            if (this.arrayOfSeeStarRequests[i] === url) {
                return true;
            }
        }

        return false;
    }
}]);