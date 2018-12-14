ktur.service("AddingToDom", ['Factory', function(Factory) {
    this.showInView = function(restData, scope) {
        Factory.create(restData, scope);
    }

    this.removeFromDom = function(fileName) {
        var elements = document.getElementsByClassName(fileName);

        for (var i = 0; i < elements.length; i++) {
            elements[i].parentElement.removeChild(elements[i]);
            // elements will be updated after every delition!
            i -= 1;
        }
    }
}]);