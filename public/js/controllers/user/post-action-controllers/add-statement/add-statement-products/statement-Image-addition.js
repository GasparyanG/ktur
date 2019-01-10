ktur.service("StatementImageAddition", ["FileNameGetter", "$compile", function(FileNameGetter, $compile){
    this.isValid = function(relationship) {
        return "uploadedImage" === relationship;
    }

    this.execute = function(hReference, scope) {
        var imageHoldingElement = document.getElementById("image-upload");
        var divElement = this.createDivElement(hReference);
        var imgElement = this.createImgElement(hReference);

        divElement.appendChild(imgElement);

        imageHoldingElement.appendChild(divElement);
        this.createDivSupportedByNg(hReference, divElement, scope);
    }

    this.createImgElement = function(hReference) {
        var imgElement = document.createElement("img");
        imgElement.src = hReference;

        return imgElement;
    }

    this.createDivElement = function(hReference) {
        var fileName = this.getFileName(hReference);

        var divElement = document.createElement('div');
        divElement.classList.add(fileName);
        
        return divElement;
    }

    this.createDivSupportedByNg = function(hReference, parentElement, scope) {
        var fileName = this.getFileName(hReference);
        

        var divElement = "<div class = '" + fileName + "' ng-click = \"removeImage('" + fileName + "')\">Remove</div>"
        angular.element(parentElement).append($compile(divElement)(scope));
    }

    this.getFileName = function(hReference) {
        return FileNameGetter.getFileName(hReference);
    }
}]);