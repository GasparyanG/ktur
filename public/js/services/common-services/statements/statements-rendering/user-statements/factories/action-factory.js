ktur.service('ActionFactory', ['StarButton', 'CommentButton', 'BasketButton', 
function(StarButton, CommentButton, BasketButton) {
    this.products = [
        StarButton,
        BasketButton,
        CommentButton
    ];

    this.renderActions = function(hrefAndRel, parentElement, scope) {
        for(var i = 0; i < this.products.length; i++) {
            hreference = hrefAndRel.href;
            relation = hrefAndRel.rel;

            if (this.products[i].isUsed(relation)) {
                // iconSize is equal to true: this is needed to render icon smaller that default (fa-2x)
                this.products[i].createElementForAtion(hreference, relation, parentElement, scope, true);
            }
        }
    }
}])