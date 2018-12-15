ktur.service("StatementErrorHighlighter", [function() {
    this.elementClassNames = {
        "error" : "error-highlighting",
    }

    this.highlightErrors = function(errorMessages) {
        // remove all previouse highlihgtings
        this.removeErrorMessages();

        for (var elementId in errorMessages) {
            var errorMessage = errorMessages[elementId];
            
            var formFiledParent = document.getElementById(elementId);
            var errorMessageBox = this.createErrorMessageBox(errorMessage);
            
            formFiledParent.parentElement.appendChild(errorMessageBox);
        }
    }

    this.createErrorMessageBox = function(errorMessage) {
        var divElement = document.createElement('div');
        divElement.classList.add(this.elementClassNames['error']);

        var textNode = document.createTextNode(errorMessage);
        
        divElement.appendChild(textNode);
        return divElement;
    }

    this.removeErrorMessages = function() {
        var errorMessageCantainer = document.getElementsByClassName(this.elementClassNames['error']);

        while(errorMessageCantainer[0]) {
            errorMessageCantainer[0].parentNode.removeChild(errorMessageCantainer[0]);
        }
    }
}]);