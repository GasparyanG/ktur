ktur.service("ActorsResourcesFetcher", [function() {
    // BASKET
    this.getbasketData = function(requiredData) {
        return requiredData["basket_data"];
    }

    this.amountOfForks = function(requiredData) {
        var basketData = this.getbasketData(requiredData);
        
        return basketData["amount_of_forks"];
    }

    this.userForkState = function(requiredData) {
        var basketData = this.getbasketData(requiredData);
        
        return basketData["user_fork_state"];
    }

    this.baksetClassName = function(requiredData) {
        var basketData = this.getbasketData(requiredData);

        return basketData["className"];
    }

    // STARS
    this.getStarData = function(requiredData) {
        return requiredData["star_data"];
    }

    this.amountOfStars = function(requiredData) {
        var starData = this.getStarData(requiredData);

        return starData["amount_of_stars"];
    }

    this.userStarState = function(requiredData) {
        var starData = this.getStarData(requiredData);

        return starData["user_star_state"];
    }

    this.starClassName = function(requiredData) {
        var starData = this.getStarData(requiredData);

        return starData["className"];
    }

    // COMMENTS
    this.getCommentData = function(requiredData) {
        return requiredData["comment_data"];
    }

    this.amountOfComments = function(requiredData) {
        var commentData = this.getCommentData(requiredData);

        return commentData["amount_of_comments"];
    }

    this.userCommentState = function(requiredData) {
        var commentData = this.getCommentData(requiredData);

        return commentData["user_comment_state"];
    }

    this.commentClassName = function(requiredData) {
        var commentData = this.getCommentData(requiredData);

        return commentData["className"];
    }
}]);