ktur.service("AnchorCreator", [function() {
    this.createAnchor = function(hrefForElement) {
        var anchor = document.createElement('a');
        anchor.href = hrefForElement;

        return anchor;
    }
}]);