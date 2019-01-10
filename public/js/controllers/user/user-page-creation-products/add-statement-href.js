ktur.service("AddStatementHref", ['AnchorCreator', function(AnchorCreator) {
    this.elementId = "add-statement";

    this.isValid = function(comparableObject) {
        return comparableObject === "add-statement";
    }

    this.execute = function(hrefForElement) {
        var desiredElement = document.getElementById(this.elementId).
        children[0].href = hrefForElement;
    }
}]);