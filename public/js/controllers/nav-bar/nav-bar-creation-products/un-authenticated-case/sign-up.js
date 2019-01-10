ktur.service("SignUp", [function() {
    this.isValid = function(comparableObject) {
        return comparableObject === "sign-up";
    }

    this.execute = function(hrefForElement) {
        var authOptionsElement = document.getElementById('sign-up');
        var newHref = this.createHrefElement(hrefForElement);

        authOptionsElement.appendChild(newHref);
    }

    this.createHrefElement = function(hrefForElement) {
        var newHref = document.createElement('a');

        newHref.href = hrefForElement;

        var textNode = this.createTextNode('Sign Up');
        
        newHref.appendChild(textNode);

        return newHref;
    }

    this.createTextNode = function(text) {
        var textNode = document.createTextNode(text);
        
        return textNode;
    }
}]);