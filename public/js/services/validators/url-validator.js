ktur.service('UrlValidator', ['ElementActivater', function(ElementActivater) {
    this.validateUrlPath = function(path) {
        var regExp = new RegExp("(/[a-zA-Z0-9]+)(/[A-Za-z0-9-]+)/([A-Za-z0-9-]+)");
        
        var matche = regExp.exec(path)
        if (matche) {
            var currentUrl = matche[2];
        }
    
        else {
            var currentUrl = path;
        }

        return currentUrl;
    }
}]);