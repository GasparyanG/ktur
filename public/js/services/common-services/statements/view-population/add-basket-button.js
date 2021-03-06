ktur.service("BasketButton", ['$compile', function($compile) {
    this.iconsSizes = {
        "small" : "",
        "medium" : "fa-2x",
    }

    this.isUsed = function(relation) {
        return relation === "basket";
    }

    this.execute = function(hreference, relation, scope) {
        var mainElement = document.getElementById("actions-over-statement");
        var divElement = document.createElement("div");
        
        // create element for action and append to divElement
        this.createElementForAtion(hreference, relation, divElement, scope);
        mainElement.appendChild(divElement);
    }

    this.createElementForAtion = function(hreference, relation, parentElement, scope, iconSize = null) {
        if (iconSize) {
            iconSize = this.iconsSizes.small;
        }

        else {
            iconSize = this.iconsSizes.medium;
        }

        var divElement = "<div class = '" + relation + ' ' + hreference + "' ng-click = \"basket('" + hreference + "')\"><i class='fas fa-shopping-basket " + iconSize + "'></i></div>"
        angular.element(parentElement).append($compile(divElement)(scope));
    }
}]);