ktur.service("UserLinks", [function() {
    this.isValid = function(comparable) {
        return ["statement-addition", "statements", "basket", "stars"].includes(comparable);
    }

    this.execute = function(hrefForElement, relate) {
        var userRelativeLinks = document.getElementById("user-relative-links");
        var divEl = this.getDivElement();
        var anchorEl = this.getAnchor(hrefForElement, relate);

        divEl.appendChild(anchorEl);
        userRelativeLinks.appendChild(divEl);
    }

    this.getDivElement = function() {
        var divEl = document.createElement("div");
        divEl.classList.add("user-links");

        return divEl;
    }

    this.getAnchor = function(hrefForElement, relate) {
        var anchorEl = document.createElement("a");
        var textEl = this.createTextEl(relate);

        anchorEl.href = hrefForElement;
        anchorEl.appendChild(textEl);

        return anchorEl;
    }

    this.createTextEl = function(text) {
        return document.createTextNode(text);
    }
}]);