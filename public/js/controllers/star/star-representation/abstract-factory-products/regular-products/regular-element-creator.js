ktur.service("RegularElementCreator", [function() {
    this.classNames = {
        "divClass" : "regular",
        "main" : "regular-star-repr",
        "image" : "regular-star-image",
        "metadata" : "regular-star-metadata",
        "title" : "regualr-star-title",
        "stars" : "regular-stars-amount"
    }

    this.mainBox = function() {
        var divElement = document.createElement('div');
        divElement.classList.add(this.classNames["main"]);

        return divElement;
    }

    this.imageSection = function(imageHref) {
        var divElement = this.createDivElement(this.classNames["image"]);

        var imgElement = document.createElement('img');
        imgElement.src = imageHref;

        divElement.appendChild(imgElement);

        return divElement;
    }

    this.metadataSection = function() {
        var divElement = this.createDivElement(this.classNames["metadata"]);

        return divElement;
    }

    this.titleSection = function(title, selfHref) {
        var divElement = this.createDivElement(this.classNames["title"]);
        var anchorElement = document.createElement('a');
        anchorElement.href = selfHref;
        var textElement = this.createTextHoldingElement(title);

        anchorElement.appendChild(textElement);
        divElement.appendChild(anchorElement);

        return divElement;
    }
    
    this.seeStarsActionSection = function(amountOfStars, seeActionHref, scope, compile, parentElement) {
        var divElement = "<div title = 'see who stared this statement' class = '" + this.classNames["stars"] + ' ' + seeActionHref + "' ng-click = \"seeStars('" + seeActionHref + "')\"><i class='fas fa-star'></i><span>" + amountOfStars + "</span></div>"
        angular.element(parentElement).append(compile(divElement)(scope));
    }

    this.createDivElement = function(className) {
        var divElement = document.createElement('div');
        divElement.classList.add(className);

        return divElement;
    }

    this.createTextHoldingElement = function(text) {
        var textElement = document.createTextNode(text);

        return textElement;
    }
}]);