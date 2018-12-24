ktur.service("StatementBoxComposer", ["ActionFactory", "StatementDataFetcher", "MetadataComposer",
function(ActionFactory, StatementDataFetcher, MetadataComposer) {
    this.typeClassNames = {
        "regular" : "regular-statement",
        "unRegular" : "not-regular-statement"
    }

    this.photoSectionNames = {
        "regular" : "regular-photo",
        "unregular" : "not-regular-photo"
    }

    this.actionSectionNames = {
        "regular" : "regular-action",
        "unregular" : "not-regular-action"
    }

    this.metadataSectionNames = {
        "regular" : "regular-metadata",
        "unregular" : "not-regular-metadata"
    }

    this.compose = function(arrayOfRequiredData, scope, isRegular = true) {
        // this means that box will be regularly displayed, but if 
        // regular is set to false then box will be rendered not regularly (NIY)
        if (isRegular) {
            return this.regularRendering(arrayOfRequiredData, scope);
        }

        else {
            // will be implemented soon (with hotel and hostel implementation)
            return this.notRegularRendering(arrayOfRequiredData, scope);
        }
    }

    this.regularRendering = function(arrayOfRequiredData, scope) {
        // main box, which stores all other portions !
        var statementBox = this.createDivWithGivenClassName(this.typeClassNames.regular);
        // photo section
        var photoSection = this.createDivWithGivenClassName(this.photoSectionNames.regular);
        var photoHref = StatementDataFetcher.fetchImage(arrayOfRequiredData);
        var photoDiv = this.addImageToDivElement(photoHref);
        photoSection.appendChild(photoDiv);
        // metadata section
        var metadataSection = this.createDivWithGivenClassName(this.metadataSectionNames.regular);
        // this will populate metadata section!
        var linkToStatement = StatementDataFetcher.fetchSelf(arrayOfRequiredData);
        MetadataComposer.create(arrayOfRequiredData, metadataSection, linkToStatement);
        
        // action section
        var actionSection = this.createDivWithGivenClassName(this.actionSectionNames.regular);
        var actions = StatementDataFetcher.fetchAction(arrayOfRequiredData);

        for (var index = 0; index < actions.length; index++) {
            ActionFactory.renderActions(actions[index], actionSection, scope);
        }

        statementBox.appendChild(photoSection);
        statementBox.appendChild(metadataSection);
        statementBox.appendChild(actionSection);

        return statementBox;
    }

    this.notRegularRendering = function(arrayOfRequiredData, scope) {
    console.log("soon");
}

this.createDivWithGivenClassName = function(className) {
    var divEl = document.createElement('div');
    divEl.classList.add(className);
    
        return divEl;
    }

    this.addImageToDivElement = function(photoHref) {
        var divEl = document.createElement('div');
        var imgEl = document.createElement('img');

        imgEl.src = photoHref;
        divEl.appendChild(imgEl);

        return divEl;
    }

    this.createDivElWithContent = function(content) {
        var divEl = document.createElement('div');
        divEl.content = content;

        return divEl;
    }
}]);