ktur.service("Cleaner", [function() {
    this.statementSubSectionsIds = [
        "ind_house",
        "hotel"
    ]

    this.cleanAll = function() {
        for (var i = 0; i < this.statementSubSectionsIds.length; i++) {
            var currentSubSection = document.getElementById(this.statementSubSectionsIds[i]);
            if (currentSubSection) {
                var childrenOfSubSection = currentSubSection.children;
                while(childrenOfSubSection.length > 0) {
                    currentSubSection.removeChild(childrenOfSubSection[0]);
                }
            }
        }
    }

    this.cleanAllErrors = function() {
        var errorsSection = document.getElementById("errors-section");

        if (errorsSection) {
            errorsSection.parentElement.removeChild(errorsSection);
        }
    }
}]);