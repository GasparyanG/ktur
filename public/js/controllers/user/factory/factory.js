ktur.service('Factory', ['UserImageInjector', 'AddStatementHref', 'StatementImageAddition', 'StatementHref', "BasketHref", "StarHref",
function(UserImageInjector, AddStatementHref, StatementImageAddition, StatementHref, BasketHref, StarHref) {
    this.products = [
        UserImageInjector,
        AddStatementHref,
        StatementHref,
        StatementImageAddition,
        BasketHref,
        StarHref
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