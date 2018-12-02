ktur.service('ErrorHighlighter', function() {
    this.elementClassNames = {
        "error" : "error-highlighting",
    }
    this.elements = {};

    this.heighlightErrors = function(errorMessages) {
        // this is important to not include the saame error message again.
        this.removeErrorMessages();

        var firstNameSection = document.getElementById("first_name_section");
        this.addElement("first_name_section", firstNameSection);
        
        var lastNameSection = document.getElementById("last_name_section");
        this.addElement("last_name_section", lastNameSection);
        
        var usernameSection = document.getElementById("username_section");
        this.addElement("username_section", usernameSection);
        
        var passwordSection = document.getElementById("password_section");
        this.addElement("password_section", passwordSection);

        this.createErrorStaringElements(errorMessages);
    }

    this.createErrorStaringElements = function(errorMessages) {
        for (var inputFeald in errorMessages) {
            if (errorMessages[inputFeald]) {
                var desiredElementFromExistingDOM = this.elements[inputFeald + "_section"];
                var divNode = this.createDivElement();
                var errorMessage = errorMessages[inputFeald];
                var textNode = this.createTextNodeCostum(errorMessage);
                
                divNode.appendChild(textNode);
                desiredElementFromExistingDOM.appendChild(divNode);
            }
        }
    }

    this.createDivElement = function() {
        $errorClassName = this.elementClassNames["error"];

        var divNode = document.createElement('div');
        divNode.classList.add($errorClassName);

        return divNode;
    }

    this.createTextNodeCostum = function(textToInjectToNode) {
        var textNode = document.createTextNode(textToInjectToNode);

        return textNode;
    }

    this.addElement = function(fealdName, DOMElement) {
        this.elements[fealdName] = DOMElement;
    }

    this.removeErrorMessages = function() {
        var errorMessageCantainer = document.getElementsByClassName(this.elementClassNames['error']);

        while(errorMessageCantainer[0]) {
            errorMessageCantainer[0].parentNode.removeChild(errorMessageCantainer[0]);
        }
    }
});