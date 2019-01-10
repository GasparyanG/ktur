ktur.service('ElementActivater', [function() {
    this.activationClassName = "currently-used"

    this.actionElements = [
        'statements',
        'basket',
        'stars',
        'add-statement'
    ];
    
    this.activateElement = function(elementId) {
        //remove previously heighlighted elements
        this.deactivateElements();

        // highlight this element by appending class name to existing ones
        var elementToActivate = document.getElementById(elementId);

        elementToActivate.classList.add(this.activationClassName);
    }

    this.deactivateElements = function() {
        for (var i = 0; i < this.actionElements.length; i++) {
            var elementToDeactivate = document.getElementById(this.actionElements[i]);
            elementToDeactivate.classList.remove(this.activationClassName);
        }
    }
}]);