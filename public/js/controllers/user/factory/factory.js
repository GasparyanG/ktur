ktur.service('Factory', ["UserImageInjector", function(UserImageInjector) {
    this.products = [
        UserImageInjector,
    ];

    this.create = function(arrayOfRelAndHref) {
        var rel = arrayOfRelAndHref["rel"];
        var hReference = arrayOfRelAndHref["href"];

        for (var i = 0; i < this.products.length; i++) {
            if (this.products[i].isValid(rel)) {
                this.products[i].execute(hReference);
            }
        }
    }
}]);