ktur.service('FactoryForNavBar', ['NavBarUserImageInjector', 'SignUp', 'LogIn', function(NavBarUserImageInjector, SignUp, LogIn) {
    this.create = function(jsonForNavBar){
        if ("authenticated" in jsonForNavBar) {
            this.runAuthenticatedHandler(jsonForNavBar["authenticated"]);
        }

        /*else if ("un_authenticated" in jsonForNavBar) {
            this.runUnAuthenticatedHandler(jsonForNavBar["un_authenticated"]);
        }*/
        else {
            this.runUnAuthenticatedHandler(jsonForNavBar["un_authenticated"]);
        }
    }

    this.runAuthenticatedHandler = function(dataInJson) {
        products = [
            NavBarUserImageInjector,
        ];

        this.sendToFactory(products, dataInJson);
    }
   
    this.runUnAuthenticatedHandler = function(dataInJson) {
        products = [
            SignUp, LogIn,
        ];

        this.sendToFactory(products, dataInJson);
    }

    this.traverseProducts = function(products, hrefAndRel){
        for (var i = 0; i < products.length; i++) {
            if (products[i].isValid(hrefAndRel["rel"])) {
                products[i].execute(hrefAndRel["href"]);
            }
        }
    }

    this.sendToFactory = function(products, dataInJson) {
        for (var i = 0; i < dataInJson.length; i++) {
            this.traverseProducts(products, dataInJson[i]);
        }
    }

}]);