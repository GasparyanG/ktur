ktur.service("LogIn", [function() {
    this.isValid = function(comparableObject) {
        return comparableObject === 'log-in';
    }

    this.execute = function(hrefForElement) {
        var authOptionsElement = document.getElementById('log-in');
        var newHref = this.createHrefElement(hrefForElement);

        authOptionsElement.appendChild(newHref);
    }

    this.createHrefElement = function(hrefForElement) {
        var newHref = document.createElement('a');

        newHref.href = hrefForElement;
        var textNode = this.createTextNode('Log In');
        
        newHref.appendChild(textNode);
        
        return newHref;
    }
    
    this.createTextNode = function(text) {
        var textNode = document.createTextNode(text);
        
        return textNode;
    }
}]);