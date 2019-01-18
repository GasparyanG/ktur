ktur.service("StatementImageAdder", [function() {
    this.isUsed = function(relation) {
        return relation === "statement_image";
    }

    this.execute = function(hreference, relation) {
        var imageContainerBox = document.getElementById("small-images");
        var divElement = document.createElement('div');
        var imgElement = this.createImgElement(hreference);

        divElement.appendChild(imgElement);
        imageContainerBox.appendChild(divElement);
    }

    this.createImgElement = function(hreference) {
        var imgElement = document.createElement('img');
        imgElement.src = hreference;

        return imgElement;
    }
}]);