ktur.controller("CommentController", ["$scope", "$http", "NewCommentRepr", "CommentSpecificFetcher",
function($scope, $http, NewCommentRepr, CommentSpecificFetcher) {
    $scope.addComment = function() {
        $http({
            method: "POST",
            url: window.location.href + "/comment",
            data:{
                "comment": $scope.commentingArea
            },

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function successCallback(response) {
            var state = null;
            if (CommentSpecificFetcher.fetchState(response.data)) {
                state = CommentSpecificFetcher.fetchState(response.data);
            }

            if (state === "true") {
                NewCommentRepr.repr(response.data);
            }

            else if (response.data = "redirect") {
                window.location.href = "/sign-up";
            }
            
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        });
    }
}]);