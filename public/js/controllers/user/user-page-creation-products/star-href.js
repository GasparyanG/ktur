ktur.service("StarHref", [function() {
    this.elementId = "stars";

    this.isValid = function(relation) {
        return relation === "stars";
    }

    this.execute = function(hrefForElement) {
        // pay attention to dot at the end of the line!
        var desiredElement = document.getElementById(this.elementId).
        children[0].href = hrefForElement;
    }
}]);