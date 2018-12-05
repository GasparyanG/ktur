ktur.service('UserImageInjector', [function() {
    this.isValid = function(relationship) {
        return relationship === "user_image";
    }

    this.execute = function(hReference) {
        var userImageElement = document.getElementById("user_image");
        var imgElement = this.createImgElement(hReference);

        userImageElement.appendChild(imgElement);
    }

    this.createImgElement = function(hReference) {
        var imgElement = document.createElement('img');
        imgElement.src = hReference;

        return imgElement;
    }
}]);