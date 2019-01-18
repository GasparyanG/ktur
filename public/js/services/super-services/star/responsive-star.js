ktur.service("ResponsiveStar", [function() {
    this.addStar = function(url) {
        var starElSection = document.getElementsByClassName(url)[0];
        starElSection.classList.add("already-stared");
        starElSection.classList.add("stared");

        this.changeSpanEl(starElSection);
    }

    this.changeSpanEl = function(starElSection) {
        var spanEl = starElSection.children[1];
        
        var spanElContent = spanEl.textContent;
        if (!isNaN(spanElContent)) {
            var spanElContent = Number(spanElContent) + 1;
        }
        
        spanEl.textContent = spanElContent;
    }
}]);