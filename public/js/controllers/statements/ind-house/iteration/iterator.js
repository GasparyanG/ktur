ktur.service("IteratorOfIndHouse", ["IndexHolder", function(IndexHolder) {
    this.arrayOfImages = [];

    this.enlargeImage = function(requiredData, scope) {
        this.getImages(requiredData);
        scope.nextImage = function() {
            IndexHolder.clearPrevious();
            IndexHolder.displayImage(IndexHolder.getNextIndex());
        }

        scope.previouseImage = function() {
            IndexHolder.clearPrevious();
            IndexHolder.displayImage(IndexHolder.getPreviousIndex());
        }

        IndexHolder.displayImage(0);
    }

    this.getImages = function(requiredData) {
        for (var key in requiredData) {
            if (typeof key === "string") {
                console.log("hello");
                if (requiredData[key]["rel"] === "statement_image") {
                    this.arrayOfImages.push(requiredData[key]["href"]);
                }
            }
        }
        
        IndexHolder.lastIndex = this.arrayOfImages.length - 1;
        IndexHolder.arrayOfImages = this.arrayOfImages;
    }
}]);