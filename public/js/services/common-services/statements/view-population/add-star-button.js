ktur.service("StarButton", ['$compile', function($compile) {
    this.isUsed = function(relation) {
        return relation === "star";
    }

    this.execute = function(hreference, relation, scope) {
        var mainElement = document.getElementById("actions-over-statement");
        var divElement = document.createElement("div");
        
        // create element for action and append to divElement
        this.createElementForAtion(hreference, relation, divElement, scope);
        mainElement.appendChild(divElement);
    }

    this.createElementForAtion = function(hreference, relation, parentElement, scope) {
        var divElement = "<div class = '" + relation + ' ' + hreference + "' ng-click = \"star('" + hreference + "')\"><i class='fas fa-star fa-2x'></i></div>"
        angular.element(parentElement).append($compile(divElement)(scope));
    }
}]);