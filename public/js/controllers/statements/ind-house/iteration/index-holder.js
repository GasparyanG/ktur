ktur.service("IndexHolder", [function() {
    this.currentIndex = 0;
    // iterator will change this value!
    this.lastIndex = null;
    this.arrayOfImages = null;

    this.getNextIndex = function() {
        if (this.currentIndex === this.lastIndex) {
            this.currentIndex = 0;
        }

        else {
            this.currentIndex += 1;
        }

        return this.currentIndex
    }

    this.getPreviousIndex = function() {
        if (this.currentIndex === 0) {
            this.currentIndex = this.lastIndex;
        }

        else {
            this.currentIndex -= 1;
        }

        return this.currentIndex;
    }

    this.displayImage = function(index) {
        var imagePath = this.arrayOfImages[index];
        var imageSection = document.getElementById("large-image");

        var divEl = this.createDivEl();
        var imgEl = this.createImgEl(imagePath);

        divEl.appendChild(imgEl);

        imageSection.appendChild(divEl);
    }

    this.createDivEl = function() {
        return document.createElement("div");
    }

    this.createImgEl = function(imagePath) {
        var imgEl = document.createElement("img");
        imgEl.src = imagePath;

        return imgEl;
    }

    this.clearPrevious = function() {
        var imageSection = document.getElementById("large-image");
        imageSection.children[0].remove();
    }
}])