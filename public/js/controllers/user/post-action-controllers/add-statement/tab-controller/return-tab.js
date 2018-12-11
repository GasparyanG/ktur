ktur.service('ReturnTab', [function() {
    this.highlightKeyWord = "used-tab";
    this.parentOfTabs = "statement-types";

    this.showTab = function(elementId) {
        this.useTab(elementId);
        this.highlight(elementId);
    }

    this.useTab = function(elementId) {
        var statementTemplate = document.getElementById(elementId);
        var parentofTamplate = statementTemplate.parentNode;
        var childrens = parentofTamplate.children;

        this.removeClassNmaeFromAllOthers(childrens);
        statementTemplate.classList.add(this.highlightKeyWord);
    }

    this.removeClassNmaeFromAllOthers = function(childrens) {
        for (var i = 0; i < childrens.length; i++) {
            if (childrens[i].classList.contains(this.highlightKeyWord)) {
                childrens[i].classList.remove(this.highlightKeyWord);
            }
        }
    }

    this.highlight = function(elementId) {
        var desiredTabElement = document.getElementById(this.parentOfTabs);
        var childrens = desiredTabElement.children;

        this.removeClassNmaeFromAllOthers(childrens);

        for (var i = 0; i < childrens.length; i++) {
            // elementId also is ment ot be as class name
            if (childrens[i].classList.contains(elementId)) {
                childrens[i].classList.add(this.highlightKeyWord);
            }
        }
    }
}]);