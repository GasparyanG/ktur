ktur.service("ErrorsDisplayer", [function() {
    this.displayErrors = function(errors) {
        var advancedSearchSection = document.getElementById("advanced-searching");
        var errorsSection = this.createErrorSection();

        for (var key in errors) {
            var errorEl = this.createDivElement(errors[key]);
            errorsSection.appendChild(errorEl);
        }

        advancedSearchSection.appendChild(errorsSection);
    }

    this.createErrorSection = function() {
        var divElement = document.createElement("div");
        divElement.id = "errors-section";

        return divElement;
    }

    this.createDivElement = function(content) {
        var divEl = document.createElement("div");
        divEl.appendChild(this.createTextElement(content));

        return divEl;
    }

    this.createTextElement = function(content) {
        var textEl = document.createTextNode(content);

        return textEl;
    }
}]);