ktur.service("IndHouseFactory", ['StatementImageAdder', 'StarButton', 'BasketButton', 'CommentButton',
function(StatementImageAdder, StarButton, BasketButton, CommentButton) {
    this.products = [
        StatementImageAdder,
        StarButton,
        BasketButton,
        CommentButton
    ];

    this.populateView = function(arrayOfHrefAndRel, scope = undefined) {
        for (var key in arrayOfHrefAndRel) {
            if (typeof key === "integer") {
                continue;
            }
            var hrefOfObject = arrayOfHrefAndRel[key]["href"];
            var relOfObject = arrayOfHrefAndRel[key]["rel"];

            for (var index = 0; index < this.products.length; index++) {
                var product = this.products[index];
                if (product.isUsed(relOfObject)) {
                    product.execute(hrefOfObject, relOfObject, scope);
                }
            }
        }
    }
}]);