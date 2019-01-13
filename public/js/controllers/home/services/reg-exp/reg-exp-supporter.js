ktur.service("RegExpSupporter", [function() {
    this.validateSearchQuery = function(webPageUrl) {
        console.log(webPageUrl);
        // "http://localhost/home?search=Zeytun"
        // to conssider spacial cahracter to litteral use "\\"
        // +=([a-zA-Z0-9%]+)
        var regExp = new RegExp("/[a-zA-Z0-9]+/home/statement-resources\\?[a-zA-Z0-9]+=([a-zA-Z0-9%]+)");
        var matche = regExp.exec(webPageUrl);
        
        if (matche) {
            return matche[1];
        }

        else {
            return false;
        }
    }
}]);