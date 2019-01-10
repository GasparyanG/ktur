ktur.service('NavBarUserImageInjector', [function() {
    this.isValid = function(comparableObject) {
        return comparableObject === 'user_image';
    }

    this.execute = function(hrefForElement) {
        var imgDivElement = document.getElementById('nav-bar-user-image');
        var imgElement = this.createImageElementInside(hrefForElement);

        imgDivElement.appendChild(imgElement);
    }

    this.createImageElementInside = function(hrefForElement) {
        var imgElement = document.createElement('img');

        imgElement.src = hrefForElement;

        return imgElement;
    }
}]);