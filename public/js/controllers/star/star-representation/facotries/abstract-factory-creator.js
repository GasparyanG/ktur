ktur.service("AbstractFactoryCreator", ['IndHouseAbstractFactory', function(IndHouseAbstractFactory) {
    this.abstractFactories = [
        IndHouseAbstractFactory
    ];

    this.create = function(statementType) {
        for (var i = 0; i < this.abstractFactories.length; i++) {
            if (this.abstractFactories[i].isUsed(statementType)) {
                return this.abstractFactories[i];
            }
        }
    }
}]);