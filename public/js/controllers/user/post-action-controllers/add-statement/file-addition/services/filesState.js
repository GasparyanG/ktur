ktur.service("FilesStateManipulator", ['AddingToDom', function(AddingToDom) {
    this.filesState = {
        "deleteAll" : true,
        "deleteFrom" : [],
        "saveTo" : []
    };

    this.addToTableListAndShow = function(dataFromResponse) {
        if (this.filesState.saveTo === 0) {
            this.filesState.saveTo = [];
        }

        var fileName = dataFromResponse[0]["data"];
        this.filesState.saveTo.push(fileName);
        console.log(this.filesState);

        AddingToDom.showInView(dataFromResponse, this);
    }

    this.removeImage = function(fileName) {
        if (this.filesState.deleteFrom === 0) {
            this.filesState.deleteFrom = [];
        }
        
        this.filesState.deleteFrom.push(fileName);
        // this dose not need to be saved in table!
        this.removeFromSaveToArray(fileName);
        AddingToDom.removeFromDom(fileName);
    }

    this.removeFromSaveToArray = function(fileName) {
        var indexOfItem = this.filesState.saveTo.indexOf(fileName);
        this.filesState.saveTo.splice(indexOfItem, 1);
    }

    this.getFilesState = function(deleteAllValue) {
        if (typeof deleteAllValue === "boolean") {
            this.filesState.deleteAll = deleteAllValue;
            
            if (this.filesState.deleteFrom.length === 0) {
                this.filesState.deleteFrom = 0;
            }

            if (this.filesState.saveTo.length === 0) {
                this.filesState.saveTo = 0;
            }

            return this.filesState;
        }
    }
}]);