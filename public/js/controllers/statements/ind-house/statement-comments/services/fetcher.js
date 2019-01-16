ktur.service("CommentSpecificFetcher", [function() {
    this.fetchComment = function(requiredData) {
        return requiredData["comment"];
    }

    this.fetchState = function(requiredData) {
        return requiredData["state"];
    }

    this.fetchUserData = function(requiredData) {
        return requiredData["user_data"];
    }

    this.fetchImagePathData = function(requiredData) {
        return requiredData["user_image_path"];
    }

    this.fetchUsername = function(requiredData) {
        return requiredData["username"];
    }
}]);