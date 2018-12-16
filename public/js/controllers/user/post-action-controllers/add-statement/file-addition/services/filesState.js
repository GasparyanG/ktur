ktur.service("FilesStateManipulator", ['AddingToDom', function(AddingToDom) {
    this.filesState = {
        "deleteAll" : true,
        "deleteFrom" : [],
        "saveTo" : []
    };

    this.addToTableListAndShow = function(dataFromResponse) {
        var fileName = dataFromResponse[0]["data"];
        this.filesState.saveTo.push(fileName);
        console.log(this.filesState);

        AddingToDom.showInView(dataFromResponse, this);
    }

    this.removeImage = function(fileName) {
        this.filesState.deleteFrom.push(fileName);
        // this dose not need to be saved in table!
        this.removeFromSaveToArray(fileName);
        AddingToDom.removeFromDom(fileName);
    }

    this.removeFromSaveToArray = function(fileName) {
        var indexOfItem = this.filesState.saveTo.indexOf(fileName);
        this.filesState.saveTo.splice(indexOfItem, 1);
    }

    this.getFilesState = function() {
        return this.filesState;
    }
}]);