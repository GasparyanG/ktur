ktur.service('StatementsStarsRepresentation', ['$compile', 'AbstractFactoryCreator', 'StarDataFetcher',
function($compile, AbstractFactoryCreator, StarDataFetcher) {
    // at runtime this will be changed by 'AbstractFactoryCreator' based on statement type!
    this.supporter = null;

    this.render = function(requiredData, scope) {
        for (var statementType in requiredData) {
            // see abstract-factory-creator.js
            this.supporter = AbstractFactoryCreator.create(statementType);
            for (var i = 0; i < requiredData[statementType].length; i++) {
                // {metadata: {…}, references: Array(n), actions: Array(n)}
                var jsonObjectOfStatementData = requiredData[statementType][i];
                this.addStarRepresentationBoxToDOM(jsonObjectOfStatementData, scope);
            }
        }
    }

    this.addStarRepresentationBoxToDOM = function(jsonObjectOfStatementData, scope) {
        // {metadata: {…}, references: Array(n), actions: Array(n)}
        var elementCreator = this.supporter.elementCreator();
        
        var statementTypeMainBoxId = this.supporter.getMainSectionId();
        var mainElement = document.getElementById(statementTypeMainBoxId);
        // all repr portions will be included into this element
        var starRepresentationBox = elementCreator.mainBox();

        // image section
        var imageHref = StarDataFetcher.fetchImage(jsonObjectOfStatementData);
        var imagePortion = elementCreator.imageSection(imageHref);
        starRepresentationBox.appendChild(imagePortion);

        // metadata section
        var metadataHoldingElement = elementCreator.metadataSection();
        
        // metadata's title section
        var title = StarDataFetcher.fetchTitle(jsonObjectOfStatementData);
        var selfHref = StarDataFetcher.fetchSelf(jsonObjectOfStatementData);
        var titleSeciton = elementCreator.titleSection(title, selfHref);
        metadataHoldingElement.appendChild(titleSeciton);
        
        //metadta's stars section
        var amountOfStars = StarDataFetcher.fetchAmountOfStars(jsonObjectOfStatementData);
        var seeActionHref = StarDataFetcher.fetchSeeStars(jsonObjectOfStatementData);
        // after this method call desired sectoin will be included into 'metadataHoldingElement'!
        elementCreator.seeStarsActionSection(amountOfStars, seeActionHref, scope, $compile, metadataHoldingElement);
        
        // adding metadata holding element to main seciton
        starRepresentationBox.appendChild(metadataHoldingElement);

        // adding star repr to main element (e.g. element which has "ind_house" id)
        mainElement.appendChild(starRepresentationBox);
    }
}]);