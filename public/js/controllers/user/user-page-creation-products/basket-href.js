ktur.service("BasketHref", [function() {
    this.elementId = "basket";

    this.isValid = function(relation) {
        return relation === "basket";
    }

    this.execute = function(hrefForElement) {
        // pay attention to dot at the end of the line!
        var desiredElement = document.getElementById(this.elementId).
        children[0].href = hrefForElement;
    }
}]);