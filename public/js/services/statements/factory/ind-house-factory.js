ktur.service("IndHouseFactory", ['StatementImageAdder', 'StarButton', 'BasketButton', 'CommentButton',
function(StatementImageAdder, StarButton, BasketButton, CommentButton) {
    this.products = [
        StatementImageAdder,
        StarButton,
        BasketButton,
        CommentButton
    ];

    this.populateView = function(arrayOfHrefAndRel, scope = undefined) {
        for (var i = 0; i < arrayOfHrefAndRel.length; i++) {
            var hrefOfObject = arrayOfHrefAndRel[i]["href"];
            var relOfObject = arrayOfHrefAndRel[i]["rel"];

            for (var index = 0; index < this.products.length; index++) {
                var product = this.products[index];
                if (product.isUsed(relOfObject)) {
                    product.execute(hrefOfObject, relOfObject, scope);
                }
            }
        }
    }
}]);