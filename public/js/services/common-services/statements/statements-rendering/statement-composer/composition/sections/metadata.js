ktur.service("MetadataComposer", ["StatementDataFetcher", function(StatementDataFetcher) {
    this.create = function(arrayOfRequiredData, parentElement, linkToStatement) {
        var price = StatementDataFetcher.fetchPrice(arrayOfRequiredData);
        var priceEl = this.createPriceDivElement(price);

        var title = StatementDataFetcher.fetchTitle(arrayOfRequiredData);
        var titleEl = this.cteateTitleElement(title, linkToStatement);

        var forOption = StatementDataFetcher.fetchOption(arrayOfRequiredData);
        var optionEl = this.createOptionElement(forOption);

        parentElement.appendChild(titleEl);
        parentElement.appendChild(priceEl);
        parentElement.appendChild(optionEl);

        return parentElement;
    }

    this.createPriceDivElement = function(price) {
        var divEl = this.createDivElement("price");
        var content = "Price: " + price;
        var textEl = this.createTextEl(content);
        divEl.appendChild(textEl);

        return divEl
    }

    this.cteateTitleElement = function(title, linkToStatement) {
        var divEl = this.createDivElement("title");
        var textEl = this.createTextEl(title);
        
        // link to statement
        var anchor = this.createAnchor(linkToStatement, textEl);

        divEl.appendChild(anchor);

        return divEl;
    }

    this.createOptionElement = function(forOption) {
        var divEl = this.createDivElement("option");
        var content = "For: " + forOption;
        var textEl = this.createTextEl(content);
        divEl.appendChild(textEl);

        return divEl;
    }

    this.createDivElement = function(className) {
        var divEl = document.createElement('div');
        divEl.classList.add(className);

        return divEl;
    }

    this.createTextEl = function(text) {
        var textEl = document.createTextNode(text);

        return textEl;
    }

    this.createAnchor = function(linkToStatement, textEl) {
        var anchor = document.createElement("a");
        anchor.href = linkToStatement;
        anchor.appendChild(textEl);

        return anchor;
    }
}]);