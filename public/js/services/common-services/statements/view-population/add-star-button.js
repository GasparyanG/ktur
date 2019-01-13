ktur.service("StarButton", ['$compile', "StatementDataFetcher", function($compile, StatementDataFetcher) {
    this.iconsSizes = {
        "small" : "",
        "medium" : "fa-2x",
    }

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

    this.createElementForAtion = function(hreference, relation, parentElement, scope, iconSize = null, arrayOfRequredData = null) {
        if (iconSize) {
            iconSize = this.iconsSizes.small;
        }

        else {
            iconSize = this.iconsSizes.medium;
        }

        var divElement = "<div class = '" + relation + ' ' + hreference + "' ng-click = \"star('" + hreference + "')\"><i class='fas fa-star " + iconSize + "'></i></div>"
        angular.element(parentElement).append($compile(divElement)(scope));
        
        if (arrayOfRequredData) {
            var starsAmount = StatementDataFetcher.fetchAmountOfStars(arrayOfRequredData);
            var isStared = StatementDataFetcher.fetchStared(arrayOfRequredData);
            var spanEl = this.createSpan(starsAmount);
            
            this.appendSpanToParentChild(spanEl, parentElement, isStared);
        }
    }

    this.createSpan = function(amountOfStars) {
        var spanEl = document.createElement("span");
        var textEl = this.createTextEl(amountOfStars);
        spanEl.appendChild(textEl);

        return spanEl;
    }

    this.createTextEl = function(amountOfStars) {
        return document.createTextNode(amountOfStars);
    }

    this.appendSpanToParentChild = function(spanEl, parentEl, isStared) {
        var children = parentEl.children;
        for (var i = 0; i < children.length; i++) {
            if (children[i].classList.contains("star")) {
                children[i].appendChild(spanEl);

                if (isStared) {
                    children[i].classList.add("already-stared");
                }
            }
        }
    }
}]);