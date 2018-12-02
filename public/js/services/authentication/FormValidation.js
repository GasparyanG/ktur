ktur.service('FormValidator', [function() {
    this.validateInput = function(scope) {
        if (scope.first_name && scope.last_name && scope.username && scope.password) {
            return true;
        }
    }
}])