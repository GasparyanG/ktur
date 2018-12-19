ktur.service("Star", [function() {
    this.giveAStar = function(scope) {
        scope.star = function(statementId) {
            console.log(statementId);
        }
    }
}]);