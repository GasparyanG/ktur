ktur.service("SelectHandler", [function() {
    this.selectElements = {
        "select-location" : "select-location",
        "rent-sell" : "rent-sell"
    }

    this.setLocationOptionAsSelected = function() {
        this.changeSelectDefault(this.selectElements["select-location"]);
    }

    this.setRentSellOptionAsSelected = function() {
        this.changeSelectDefault(this.selectElements["rent-sell"]);
    }

    this.changeSelectDefault = function(elementId) {
        window.addEventListener('load', function() {
            var optionElements = document.getElementById(elementId).getElementsByTagName('option');
            optionElements[0].value = 0;    
            optionElements[0].textContent = "Select"
        });
    }
}]);