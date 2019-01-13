ktur.service('NavBarUserImageInjector', [function() {
    this.isValid = function(comparableObject) {
        return comparableObject === 'user_image';
    }

    this.execute = function(hrefForElement, relate, data) {
        var imgDivElement = document.getElementById('nav-bar-user-image');
        var imgElement = this.createImageElementInside(hrefForElement);

        var anchor = this.createAnchor(data);
        anchor.appendChild(imgElement);

        imgDivElement.appendChild(anchor);
    }

    this.createImageElementInside = function(hrefForElement) {
        var imgElement = document.createElement('img');

        imgElement.src = hrefForElement;

        return imgElement;
    }

    this.createAnchor = function(href) {
        var anchor = document.createElement("a");
        anchor.href = href;

        return anchor;
    }
}]);