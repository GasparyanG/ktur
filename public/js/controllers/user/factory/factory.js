ktur.service('Factory', ['UserImageInjector', 'AddStatementHref', function(UserImageInjector, AddStatementHref) {
    this.products = [
        UserImageInjector,
        AddStatementHref,
    ];

    this.create = function(arrayOfRelAndHref) {
        for (var index = 0; index < arrayOfRelAndHref.length; index++) {
            var rel = arrayOfRelAndHref[index]["rel"];
            var hReference = arrayOfRelAndHref[index]["href"];
            
            for (var i = 0; i < this.products.length; i++) {
                if (this.products[i].isValid(rel)) {
                    this.products[i].execute(hReference);
                }
            }
        }
    }
}]);