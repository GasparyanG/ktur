ktur.service('Factory', ['UserImageInjector', 'AddStatementHref', 'StatementImageAddition',
function(UserImageInjector, AddStatementHref, StatementImageAddition) {
    this.products = [
        UserImageInjector,
        AddStatementHref,
        StatementImageAddition,
    ];

    this.create = function(arrayOfRelAndHref, scope = undefined) {
        for (var index = 0; index < arrayOfRelAndHref.length; index++) {
            var rel = arrayOfRelAndHref[index]["rel"];
            var hReference = arrayOfRelAndHref[index]["href"];
            
            for (var i = 0; i < this.products.length; i++) {
                if (this.products[i].isValid(rel)) {
                    this.products[i].execute(hReference, scope);
                }
            }
        }
    }
}]);