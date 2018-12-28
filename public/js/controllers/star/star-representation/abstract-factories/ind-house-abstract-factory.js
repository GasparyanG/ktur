ktur.service("IndHouseAbstractFactory", ['RegularElementCreator' ,function(RegularElementCreator) {
    this.isUsed = function(statementType) {
        return statementType === "ind_house";
    }

    this.elementCreator = function() {
        return RegularElementCreator;
    }

    this.getMainSectionId = function() {
        return "ind_house";
    }
}]);