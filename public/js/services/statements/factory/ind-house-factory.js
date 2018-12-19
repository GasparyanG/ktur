ktur.service("IndHouseFactory", ['StatementImageAdder', function(StatementImageAdder) {
    this.products = [
        StatementImageAdder
    ];

    this.populateView = function(arrayOfHrefAndRel) {
        for (var i = 0; i < arrayOfHrefAndRel.length; i++) {
            var hrefOfObject = arrayOfHrefAndRel[i]["href"];
            var relOfObject = arrayOfHrefAndRel[i]["rel"];

            for (var index = 0; index < this.products.length; index++) {
                var product = this.products[index];
                if (product.isUsed(relOfObject)) {
                    product.execute(hrefOfObject, relOfObject);
                }
            }
        }
    }
}]);