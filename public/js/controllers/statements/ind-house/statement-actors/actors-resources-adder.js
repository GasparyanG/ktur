ktur.service("ActorsResourceAdder", ["ActorsResourcesFetcher", 
function(ActorsResourcesFetcher) {
    this.addRecources = function(requiredData) {
        this.starResources(requiredData);
        this.commentResources(requiredData);
        this.basketResources(requiredData);
    }

    this.starResources = function(requiredData) {
        var className = ActorsResourcesFetcher.starClassName(requiredData);
        var starActorSection = document.getElementsByClassName(className)[0];

        if (ActorsResourcesFetcher.userStarState(requiredData)) {
            starActorSection.classList.add("stared");
        }

        var amountOfStars = ActorsResourcesFetcher.amountOfStars(requiredData);
        var spanWithAmountOfStars = this.createSpanElWithContent(amountOfStars);

        starActorSection.appendChild(spanWithAmountOfStars);
    }

    this.commentResources = function(requiredData) {
        var className = ActorsResourcesFetcher.commentClassName(requiredData);
        var commentActorSection = document.getElementsByClassName(className)[0];

        if (ActorsResourcesFetcher.userCommentState(requiredData)) {
            commentActorSection.classList.add("commented");
        }

        var amountOfComments = ActorsResourcesFetcher.amountOfComments(requiredData);
        var spanWithAmountOfComments = this.createSpanElWithContent(amountOfComments);

        commentActorSection.appendChild(spanWithAmountOfComments);
    }

    this.basketResources = function(requiredData) {
        var className = ActorsResourcesFetcher.baksetClassName(requiredData);
        var basketActorSection = document.getElementsByClassName(className)[0];

        if (ActorsResourcesFetcher.userForkState(requiredData)) {
            basketActorSection.classList.add("forked");
        }

        var amountOfForks = ActorsResourcesFetcher.amountOfForks(requiredData);
        var spanWithAmountOfForks = this.createSpanElWithContent(amountOfForks);

        basketActorSection.appendChild(spanWithAmountOfForks);
    }

    this.createSpanElWithContent = function(content) {
        var spanEl = document.createElement("span");
        var textEl = this.createTextEl(content);

        spanEl.appendChild(textEl);
        return spanEl;
    }

    this.createTextEl = function(content) {
        return document.createTextNode(content);
    }
}]);