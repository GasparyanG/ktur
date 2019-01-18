ktur.service("ResponsiveBasket", [function() {
    this.fork = function(url) {
        var basketElSection = document.getElementsByClassName(url)[0];
        basketElSection.classList.add("forked");

        this.changeSpan(basketElSection);
    }

    this.changeSpan = function(basketElSection) {
        var spanEl = basketElSection.children[1];

        if (spanEl) {
            var spanElContent = spanEl.textContent;
            if (!isNaN(spanElContent)) {
                var spanElContent = Number(spanElContent) + 1;
            }
            
            spanEl.textContent = spanElContent;
        }
    }
}]);