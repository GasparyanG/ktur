ktur.service("CommentButtonForRedirection", ["$http", "RedirectionUrlPreparer",
function($http, RedirectionUrlPreparer) {
    this.activateCommentButton = function(scope) {
        scope.comment = function(url) {
            window.location.href = RedirectionUrlPreparer.prepareRedirectingUrl(url);
        }
    }
}]);