ktur.service('UrlValidator', ['ElementActivater', function(ElementActivater) {
    this.validateUrlPath = function(path) {
        var regExp = new RegExp("([/A-Za-z0-9]*)#([A-Za-z0-9-]+)");
        
        var matche = regExp.exec(path)
        if (matche) {
            var currentUrl = matche[1];
            var elementId = matche[2];
            ElementActivater.activateElement(elementId);
        }
    
        else {
            var currentUrl = path;
        }

        return currentUrl;
    }
}]);