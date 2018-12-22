ktur.service("StatementHref", [function() {
    this.elementId = "statements";

    this.isValid = function(comparableObject) {
        return comparableObject === "statements";
    }

    this.execute = function(hrefForElement) {
        var desiredElement = document.getElementById(this.elementId).
        children[0].href = hrefForElement;
    }
}]);